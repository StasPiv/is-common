<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface QueueCleanerFactoryInterface
{
    public function createQueueCleaner(): QueueCleanerInterface;
}