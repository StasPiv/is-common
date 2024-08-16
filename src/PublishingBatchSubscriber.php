<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventTypeAwareProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;

class PublishingBatchSubscriber implements Contract\SubscriberInterface
{
    public function __construct(
        private readonly PublisherInterface      $publisher,
    ) {
    }

    public function update(EventTypeAwareProcessDataInterface $processData): void
    {
        $this->publisher->publishBatch();
    }
}