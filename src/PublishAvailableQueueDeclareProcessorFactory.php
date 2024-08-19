<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueDeclareProcessorInterface;

class PublishAvailableQueueDeclareProcessorFactory implements Contract\QueueDeclareProcessorFactoryInterface
{
    public function __construct(
        private readonly QueueBatchConfigurationInterface $queueBatchConfiguration,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createQueueDeclareProcessor(): QueueDeclareProcessorInterface
    {
        return new PublishAvailableQueueDeclareProcessor(
            $this->queueBatchConfiguration,
            $this->eventManagerFactory->createEventManager(),
        );
    }
}