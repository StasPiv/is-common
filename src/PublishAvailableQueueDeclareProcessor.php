<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface;

class PublishAvailableQueueDeclareProcessor implements Contract\QueueDeclareProcessorInterface
{
    public function __construct(
        private readonly QueueBatchConfigurationInterface $queueBatchConfiguration,
    ) {
    }

    public function processQueueDeclare(string $queue, int $messageCount, int $consumerCount): bool
    {
        $queueSizeLimit = $this->queueBatchConfiguration->getQueueSizeLimit($queue);
        $batchSize = $this->queueBatchConfiguration->getBatchSize($queue);

        return $messageCount + $batchSize < $queueSizeLimit;
    }
}