<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface AMQPConsumerConfigurationInterface
{
    public function getQueue(): string;
}