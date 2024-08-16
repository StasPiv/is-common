<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class PublishingBatchSubscriberFactory implements Contract\SubscriberFactoryInterface
{
    public function __construct(
        private readonly PublisherFactoryInterface $publisherFactory,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createSubscriber(): SubscriberInterface
    {
        return new PublishingBatchSubscriber(
            $this->publisherFactory->createPublisher(),
            $this->eventManagerFactory->createEventManager(),
        );
    }
}