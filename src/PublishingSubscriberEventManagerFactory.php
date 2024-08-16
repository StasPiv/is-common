<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class PublishingSubscriberEventManagerFactory implements Contract\EventManagerFactoryInterface
{
    public function __construct(
        private readonly SubscriberFactoryInterface $loggingSubscriberFactory,
    ) {
    }

    public function createEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessagePublished,
            $this->loggingSubscriberFactory->createSubscriber()
        );

        return $eventManager;
    }
}