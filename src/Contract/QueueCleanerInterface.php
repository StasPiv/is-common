<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface QueueCleanerInterface
{
    public function cleanQueues(array $queues): void;
}