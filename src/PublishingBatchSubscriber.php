<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventTypeAwareProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;

class PublishingBatchSubscriber implements Contract\SubscriberInterface
{
    public function __construct(
        private readonly PublisherInterface      $publisher,
        private readonly EventManagerInterface   $eventManager,
    ) {
    }

    public function update(EventTypeAwareProcessDataInterface $processData): void
    {
        $this->publisher->publishBatch();

        $this->eventManager->notify(PublisherEventTypeEnum::PublishBatchMessages, $processData);
    }
}