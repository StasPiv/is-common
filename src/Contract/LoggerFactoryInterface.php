<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use Psr\Log\LoggerInterface;

interface LoggerFactoryInterface
{
    public function createLogger(): LoggerInterface;
}
