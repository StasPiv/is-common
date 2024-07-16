<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface KeyFinderInterface
{
    public function getValue(string $key): int;

    public function exists(string $key): bool;
}