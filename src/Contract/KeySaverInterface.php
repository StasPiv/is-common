<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface KeySaverInterface
{
    public function saveIntValue(string $key, int $value): void;

    public function saveValue(string $key, string $value): void;
}