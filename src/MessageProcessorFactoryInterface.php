<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;

interface MessageProcessorFactoryInterface
{
    public function createMessageProcessor(): MessageProcessorInterface;
}