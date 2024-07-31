<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface MysqliConfigurationInterface
{
    public function getHost(): string;

    public function getDatabase(): string;

    public function getUserName(): string;

    public function getPassword(): string;

    public function getPort(): int;
}