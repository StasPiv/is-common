<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface QueueCleanerConfigurationInterface
{
    public function getQueues(): array;
}
