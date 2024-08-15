<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;

class AMQPPublisher implements PublisherInterface
{
    const BATCH_SIZE = 1000;
    const QUEUE_SIZE_LIMIT = 10000;

    private static array $queueSizes = [];

    public function __construct(
        private readonly AMQPChannel           $channel,
        private readonly string                $queue,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function publish(StringInterface $model): void
    {
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

        if (self::$queueSizes[$this->queue] === self::BATCH_SIZE) {
            $this->publishBatchRecursive();

            self::$queueSizes[$this->queue] = 0;
        }
    }

    private function publishBatchRecursive(): void
    {
        list($queueName, $messageCount, $consumerCount)
            = $this->channel->queue_declare($this->queue, true);

        while($messageCount > self::QUEUE_SIZE_LIMIT) {
            $this->eventManager->notify(
                PublisherEventTypeEnum::MessageCountGreaterThanLimit,
                new DataAwareProcessDataModel(["queue" => $queueName, "messageCount" => $messageCount,]),
            );
            sleep(1);

            list($queueName, $messageCount, $consumerCount)
                = $this->channel->queue_declare($this->queue, true);
        }

        $this->eventManager->notify(
            PublisherEventTypeEnum::MessageCountLessThanLimit,
            new DataAwareProcessDataModel(["message" => "Publish batch",])
        );
        $this->channel->publish_batch();
    }

    public function __destruct()
    {
        $this->channel->publish_batch();
    }
}