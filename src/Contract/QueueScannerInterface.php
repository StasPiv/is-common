<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface QueueScannerInterface
{
    public function scanQueue(string $queue): void;
}