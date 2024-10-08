<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Predis\Client;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyFinderInterface;

class RedisKeyFinder implements KeyFinderInterface
{
    public function __construct(
        private readonly Client $redisClient
    ) {
    }

    public function getIntValue(string $key): ?int
    {
        return (int) $this->redisClient->get($key);
    }

    public function getStringValue(string $key): ?string
    {
        return (string) $this->redisClient->get($key);
    }

    public function exists(string $key): bool
    {
        return $this->redisClient->get($key) !== null;
    }
}
