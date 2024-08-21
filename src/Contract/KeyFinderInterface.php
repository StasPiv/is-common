<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface KeyFinderInterface
{
    public function getIntValue(string $key): ?int;

    public function getStringValue(string $key): ?string;

    public function exists(string $key): bool;
}