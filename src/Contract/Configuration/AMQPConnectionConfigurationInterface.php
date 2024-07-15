<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface AMQPConnectionConfigurationInterface
{
    public function getHost(): string;

    public function getPort(): int;

    public function getUser(): string;

    public function getPassword(): string;
}