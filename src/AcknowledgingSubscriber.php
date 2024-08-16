<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AckableInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventTypeAwareProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class AcknowledgingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function update(EventTypeAwareProcessDataInterface $processData): void
    {
        $message = $processData->getProcessData();

        if (!$message instanceof AckableInterface) {
            return;
        }

        $message->ack();

        $this->eventManager->notify(ProcessEventTypeEnum::MessageAcked, $processData);
    }
}