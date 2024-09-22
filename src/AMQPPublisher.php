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
        $this->channel->set_nack_handler(
            function (AMQPMessage $message) {
                $this->eventManager->notify(
                    PublisherEventTypeEnum::NackReceived,
                    new DataAwareProcessDataModel([
                        'queue' => $message->getRoutingKey(),
                        'message' => $message->getBody(),
                    ])
                );

                $this->channel->basic_publish(
                    $message,
                    $message->getExchange(),
                    $message->getRoutingKey(),
                );
            }
        );

        $this->channel->confirm_select();
    }

    public function publish(StringInterface $model): void
    {
        if ($this->queueBatchConfiguration->isForce() || $this->queueBatchConfiguration->getBatchSize($this->queue) === 0) {
            $this->channel->basic_publish(
                new AMQPMessage((string) $model),
                '',
                $this->queue,
            );

            if ($model instanceof ProcessDataInterface) {
                $this->eventManager->notify(
                    PublisherEventTypeEnum::Publish,
                    new DataAwareProcessDataModel([
                        'queue' => $this->queue,
                        'model' => (string) $model,
                    ]),
                );
            }

            $this->channel->wait_for_pending_acks();

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

    /**
     * @throws \Throwable
     */
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
        } catch (Throwable $exception) {
            $this->eventManager->notify(
                PublisherEventTypeEnum::PublishFail,
                new DataAwareProcessDataModel(["queue" => $this->queue, 'message' => $exception->getMessage()])
            );

            throw $exception;
        }
    }

    private function waitForPublish(): void
    {
        $this->queueScanner->scanQueue($this->queue);
    }
}