<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\QueueScannerEventTypeEnum;

class PublisherEventManagerFactory implements EventManagerFactoryInterface
{
    public function __construct(
        private readonly SubscriberFactoryInterface $loggingSubscriberFactory,
        private readonly SubscriberFactoryInterface $terminatorSubscriberFactory,
    ) {
    }

    public function createEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        foreach ($this->getLoggingSubscriberEvents() as $loggingSubscriberEvent) {
            $eventManager->subscribe(
                $loggingSubscriberEvent,
                $this->loggingSubscriberFactory->createSubscriber($loggingSubscriberEvent),
            );
        }

        $eventManager->subscribe(
            PublisherEventTypeEnum::PublishFail,
            $this->terminatorSubscriberFactory->createSubscriber()
        );

        return $eventManager;
    }

    /**
     * @return array<\StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface>
     */
    protected function getLoggingSubscriberEvents(): array
    {
        return [
            QueueScannerEventTypeEnum::WaitForMessages,
            PublisherEventTypeEnum::WaitForPublish,
            PublisherEventTypeEnum::Publish,
            PublisherEventTypeEnum::PublishBatchMessages,
            PublisherEventTypeEnum::PublishFail,
            PublisherEventTypeEnum::QueueOverloadedForFinalBatch,
            PublisherEventTypeEnum::NackReceived,
        ];
    }
}