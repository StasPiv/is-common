<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\ProcessEventTypeEnum;

interface ProcessDataInterface
{
    public function getEventType(): ProcessEventTypeEnum;

    public function getMessage(): MessageInterface;
}