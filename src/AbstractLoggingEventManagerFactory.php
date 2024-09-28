<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;

abstract class AbstractLoggingEventManagerFactory implements Contract\EventManagerFactoryInterface
{
    public function __construct(
        private readonly SubscriberFactoryInterface $loggingSubscriberFactory,
    ) {
    }

    public function createEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        foreach ($this->getLoggingSubscriberEvents() as $loggingSubscriberEvent) {
            $eventManager->subscribe(
                $loggingSubscriberEvent,
                $this->loggingSubscriberFactory->createSubscriber(),
            );
        }

        return $eventManager;
    }

    /**
     * @return array<\StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface>
     */
    abstract protected function getLoggingSubscriberEvents(): array;
}