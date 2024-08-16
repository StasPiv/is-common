<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface;

class EventTypeAwareProcessData implements Contract\EventTypeAwareProcessDataInterface
{
    public function __construct(
        private readonly EventTypeInterface $eventType,
        private readonly ProcessDataInterface $processData,
    ) {
    }

    public function getEventType(): EventTypeInterface
    {
        return $this->eventType;
    }

    public function getProcessData(): ProcessDataInterface
    {
        return $this->processData;
    }

    public function __toString(): string
    {
        return (string) $this->processData;
    }
}