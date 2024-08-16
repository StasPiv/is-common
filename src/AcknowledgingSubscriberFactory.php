<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class AcknowledgingSubscriberFactory implements Contract\SubscriberFactoryInterface
{
    public function __construct(
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createSubscriber(): SubscriberInterface
    {
        return new AcknowledgingSubscriber(
            $this->eventManagerFactory->createEventManager(),
        );
    }
}