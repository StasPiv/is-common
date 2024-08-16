<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface QueueBatchConfigurationInterface
{
    public function getBatchSize(string $queue): int;

    public function getQueueSizeLimit(string $queue): int;
}
