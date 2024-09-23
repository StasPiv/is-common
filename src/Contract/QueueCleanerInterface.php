<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\QueueCleaner;

interface QueueCleanerInterface
{
    public function cleanQueues(array $queues): void;

    public function cleanUserQueues(array $queues, string $user): void;
}