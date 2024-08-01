<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class PublishingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly PublisherInterface      $publisher,
        private readonly EventManagerInterface   $eventManager,
    ) {
    }

    /**
     * @param ProcessDataInterface $processData
     *
     * @throws \StanislavPivovartsev\InterestingStatistics\Common\Exception\SubscriberException
     */
    public function update(ProcessDataInterface $processData): void
    {
        $this->publisher->publish($processData);

        $this->eventManager->notify(ProcessEventTypeEnum::MessagePublished, $processData);
    }
}
