<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublishingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class MessageProcessorEventManagerFactory implements EventManagerFactoryInterface
{
    public function __construct(
        protected LoggingSubscriberFactoryInterface $loggingSubscriberFactory,
        protected PublishingSubscriberFactoryInterface $publishingSubscriberFactory,
    ) {
    }

    public function createEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        foreach ($this->getLoggingSubscriberEvents() as $loggingSubscriberEvent) {
            $eventManager->subscribe(
                $loggingSubscriberEvent,
                $this->loggingSubscriberFactory->createLoggingSubscriber($loggingSubscriberEvent),
            );
        }

        $eventManager->subscribe(ProcessEventTypeEnum::ModelCreated, $this->publishingSubscriberFactory->createPublishingSubscriber());

        return $eventManager;
    }

    /**
     * @return array<\StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface>
     */
    protected function getLoggingSubscriberEvents(): array
    {
        return [
            ProcessEventTypeEnum::ModelFound,
            ProcessEventTypeEnum::ModelNotFound,
            ProcessEventTypeEnum::ModelSaveFailed,
            ProcessEventTypeEnum::ModelCreated,
        ];
    }
}