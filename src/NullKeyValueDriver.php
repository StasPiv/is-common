<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeySaverInterface;

class NullKeyValueDriver implements KeyFinderInterface, KeySaverInterface
{
    public function getIntValue(string $key): ?int
    {
        return null;
    }

    public function exists(string $key): bool
    {
        return false;
    }

    public function saveIntValue(string $key, int $value): void
    {

    }

    public function saveValue(string $key, string $value): void
    {
    }
}