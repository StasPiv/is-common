<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;

class AMQPPublisher implements PublisherInterface
{
    private static array $queueSizes = [];

    public function __construct(
        private readonly AMQPChannel           $channel,
        private readonly string                $queue,
        private readonly EventManagerInterface $eventManager,
        private readonly QueueBatchConfigurationInterface $queueBatchConfiguration,
    ) {
    }

    public function publish(StringInterface $model): void
    {
        if ($this->queueBatchConfiguration->isForce()) {
            $this->channel->basic_publish(
                new AMQPMessage((string) $model),
                '',
                $this->queue,
            );

            return;
        }

        $this->channel->batch_basic_publish(
            new AMQPMessage((string) $model),
            '',
            $this->queue,
        );

        if (!isset(self::$queueSizes[$this->queue])) {
            self::$queueSizes[$this->queue] = 1;
        } else {
            self::$queueSizes[$this->queue]++;
        }

        if (self::$queueSizes[$this->queue] === $this->queueBatchConfiguration->getBatchSize($this->queue)) {
            $this->publishBatchDelayed();

            self::$queueSizes[$this->queue] = 0;
        }
    }

    public function publishBatch(): void
    {
        $messageCount = $this->getMessageCount();

        if ($messageCount + $this->queueBatchConfiguration->getBatchSize($this->queue) > $this->queueBatchConfiguration->getQueueSizeLimit($this->queue)) {
            $this->eventManager->notify(
                PublisherEventTypeEnum::QueueOverloadedForFinalBatch,
                new DataAwareProcessDataModel(["queue" => $this->queue,])
            );

            return;
        }

        $this->eventManager->notify(
            PublisherEventTypeEnum::PublishBatchMessages,
            new DataAwareProcessDataModel(["queue" => $this->queue,])
        );
        $this->channel->publish_batch();
    }

    private function publishBatchDelayed(): void
    {
        $messageCount = $this->getMessageCount();

        while($messageCount > $this->queueBatchConfiguration->getQueueSizeLimit($this->queue)) {
            $this->eventManager->notify(
                PublisherEventTypeEnum::MessageCountGreaterThanLimit,
                new DataAwareProcessDataModel(["queue" => $this->queue, "messageCount" => $messageCount,]),
            );
            sleep(1);

            $messageCount = $this->getMessageCount();
        }

        $this->publishBatch();
    }

    public function __destruct()
    {
        $this->publishBatch();
    }

    private function getMessageCount(): int
    {
        list($queueName, $messageCount, $consumerCount)
            = $this->channel->queue_declare($this->queue, true);

        return $messageCount;
    }
}