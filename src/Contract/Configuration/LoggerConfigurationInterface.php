<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface LoggerConfigurationInterface
{
    public function getLogName(): string;

    public function getLogLevel(): string;
}