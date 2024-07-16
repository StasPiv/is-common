<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface RedisConfigurationInterface
{
    public function getScheme(): string;

    public function getHost(): string;

    public function getPort(): int;
}