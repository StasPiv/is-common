<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;

class PublishAvailableQueueDeclareProcessor implements Contract\QueueDeclareProcessorInterface
{
    public function __construct(
        private readonly QueueBatchConfigurationInterface $queueBatchConfiguration,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function processQueueDeclare(string $queue, int $messageCount, int $consumerCount): bool
    {
        $queueSizeLimit = $this->queueBatchConfiguration->getQueueSizeLimit($queue);
        $batchSize = $this->queueBatchConfiguration->getBatchSize($queue);
        $readyForPublish = $messageCount + $batchSize < $queueSizeLimit;

        if (!$readyForPublish) {
            $this->eventManager->notify(
                PublisherEventTypeEnum::QueueOverloadedForFinalBatch,
                new DataAwareProcessDataModel([
                    'queueSizeLimit' => $queueSizeLimit,
                    'batchSize' => $batchSize,
                ])
            );
        }

        return !$readyForPublish;
    }
}