<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface;

interface EventTypeAwareProcessDataInterface extends ProcessDataInterface
{
    public function getEventType(): EventTypeInterface;
}