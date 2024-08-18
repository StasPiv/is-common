<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface QueueDeclareProcessorInterface
{
    public function processQueueDeclare(string $queue, int $messageCount, int $consumerCount): bool;
}
