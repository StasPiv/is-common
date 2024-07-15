<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class AcknowledgingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly EventManagerInterface $eventManager,
        private readonly ProcessDataBuilderInterface $processDataBuilder,
    ) {
    }

    public function update(ProcessDataInterface $data): void
    {
        $data->getMessage()->ack();

        $this->eventManager->notify(
            $this->processDataBuilder->buildMessageAckedProcessData($data->getMessage())
        );
    }
}