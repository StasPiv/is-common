<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueScannerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;
use Throwable;

class AMQPPublisher implements PublisherInterface
{
    private static array $queueSizes = [];

    public function __construct(
        private readonly AMQPChannel           $channel,
        private readonly string                $queue,
        private readonly EventManagerInterface $eventManager,
        private readonly QueueBatchConfigurationInterface $queueBatchConfiguration,
        private readonly QueueScannerInterface $queueScanner,
    ) {
    }

    public function publish(StringInterface $model): void
    {
        if ($model instanceof ProcessDataInterface) {
            $this->eventManager->notify(
                PublisherEventTypeEnum::Publish,
                $model,
            );
        }

        if ($this->queueBatchConfiguration->isForce() || $this->queueBatchConfiguration->getBatchSize($this->queue) === 0) {
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
            $this->publishBatch();

            self::$queueSizes[$this->queue] = 0;
        }
    }

    public function publishBatch(): void
    {
        if ($this->queueBatchConfiguration->getBatchSize($this->queue) === 0) {
            return;
        }

        $this->waitForPublish();

        $this->eventManager->notify(
            PublisherEventTypeEnum::PublishBatchMessages,
            new DataAwareProcessDataModel(["queue" => $this->queue,])
        );
        try {
            $this->channel->publish_batch();
        } catch (Throwable) {
            $this->eventManager->notify(
                PublisherEventTypeEnum::PublishFail,
                new DataAwareProcessDataModel(["queue" => $this->queue,])
            );
            sleep(5);
            $this->publishBatch();
        }
    }

    private function waitForPublish(): void
    {
        $this->queueScanner->scanQueue($this->queue);
    }

    public function __destruct()
    {
        $this->publishBatch();
    }
}