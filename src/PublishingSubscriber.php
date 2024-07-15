<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class PublishingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly PublisherInterface                          $publisher,
        private readonly MessageBuilderInterface                     $messageBuilder,
        private readonly EventManagerInterface $eventManager,
        private readonly ProcessDataBuilderInterface $processDataBuilder,
    ) {
    }

    /**
     * @param ProcessDataInterface $processData
     *
     * @throws \StanislavPivovartsev\InterestingStatistics\Common\Exception\SubscriberException
     */
    public function update(ProcessDataInterface $processData): void
    {
        $message = $this->messageBuilder->buildMessageFromStringObject($processData);

        $this->publisher->publish($message);

        $this->eventManager->notify(
            $this->processDataBuilder->buildMessagePublishedProcessData($message),
        );
    }
}
