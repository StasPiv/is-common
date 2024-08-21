<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Predis\Client;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeySaverInterface;

class RedisKeySaver implements KeySaverInterface
{
    public function __construct(
        private readonly Client $redisClient,
    ) {
    }

    public function saveIntValue(string $key, int $value): void
    {
        $this->redisClient->set($key, $value);
    }

    public function saveValue(string $key, string $value): void
    {
        $this->redisClient->set($key, $value);
    }
}