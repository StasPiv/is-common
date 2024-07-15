<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

abstract class AbstractProcessData implements ProcessDataInterface
{
    public function __construct(
        protected readonly ProcessEventTypeEnum $eventType,
        protected MessageInterface              $message,
    ) {
    }

    public function getEventType(): ProcessEventTypeEnum
    {
        return $this->eventType;
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    public function __toString(): string
    {
        return (string) $this->getMessage();
    }
}
