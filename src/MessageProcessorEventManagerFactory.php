<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;

class MessageProcessorEventManagerFactory implements EventManagerFactoryInterface
{
    public function __construct(
        protected SubscriberFactoryInterface $loggingSubscriberFactory,
        protected SubscriberFactoryInterface $publishingSubscriberFactory,
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

        $eventManager->subscribe(ProcessEventTypeEnum::MessagePreparedForPublish, $this->publishingSubscriberFactory->createSubscriber());

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
            ProcessEventTypeEnum::MessagePreparedForPublish,
            ProcessEventTypeEnum::ModelPublished,
            PublisherEventTypeEnum::MessageCountGreaterThanLimit,
        ];
    }
}