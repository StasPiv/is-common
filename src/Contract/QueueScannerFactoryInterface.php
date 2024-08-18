<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface QueueScannerFactoryInterface
{
    public function createQueueScanner(): QueueScannerInterface;
}