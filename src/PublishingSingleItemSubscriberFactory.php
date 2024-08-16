<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class PublishingSingleItemSubscriberFactory implements SubscriberFactoryInterface
{
    public function __construct(
        private readonly PublisherFactoryInterface $publisherFactory,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createSubscriber(): SubscriberInterface
    {
        return new PublishingSingleItemSubscriber(
            $this->publisherFactory->createPublisher(),
            $this->eventManagerFactory->createEventManager(),
        );
    }
}