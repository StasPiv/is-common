<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class PublishingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly PublisherInterface      $publisher,
        private readonly EventManagerInterface   $eventManager,
        private readonly MessageBuilderInterface $messageBuilder,
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

        $this->eventManager->notify(ProcessEventTypeEnum::MessagePublished, $processData);
    }
}
