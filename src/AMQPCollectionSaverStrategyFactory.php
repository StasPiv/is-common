<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherFactoryInterface;

class AMQPCollectionSaverStrategyFactory implements CollectionSaverStrategyFactoryInterface
{
    public function __construct(
        private readonly PublisherFactoryInterface $publisherFactory,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createSaverStrategy(): CollectionSaverStrategyInterface
    {
        return new AMQPCollectionSaverStrategy(
            $this->publisherFactory->createPublisher(),
            $this->eventManagerFactory->createEventManager(),
        );
    }
}