<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SuccessfulProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\SubscriberException;

class PublishingSavedDataSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly PublisherInterface                          $publisher,
        private readonly MessageModelFromProcessDataBuilderInterface $messageModelBuilder,
        private readonly MessageBuilderInterface                     $messageBuilder,
        private readonly EventManagerInterface $eventManager,
        private readonly ProcessDataBuilderInterface $processDataBuilder,
    ) {
    }

    /**
     * @param SuccessfulProcessDataInterface|ProcessDataInterface $data
     *
     * @throws \StanislavPivovartsev\InterestingStatistics\Common\Exception\SubscriberException
     */
    public function update(ProcessDataInterface $data): void
    {
        if (!$data instanceof SuccessfulProcessDataInterface) {
            throw new SubscriberException('Publishing subscriber can handle only successful process data');
        }

        $model = $this->messageModelBuilder->buildMessageModelFromProcessData($data);
        $message = $this->messageBuilder->buildMessageFromMessageModel($model);

        $this->publisher->publish($message);

        $this->eventManager->notify(
            $this->processDataBuilder->buildMessagePublishedProcessData($message),
        );
    }
}
