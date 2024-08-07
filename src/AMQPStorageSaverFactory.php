<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherFactoryInterface;

class AMQPStorageSaverFactory implements StorageSaverFactoryInterface
{
    public function __construct(
        private readonly PublisherFactoryInterface $publisherFactory,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createStorageSaver(): StorageSaverInterface
    {
        return new AMQPStorageSaver(
            $this->publisherFactory->createPublisher(),
            $this->eventManagerFactory->createEventManager(),
        );
    }
}