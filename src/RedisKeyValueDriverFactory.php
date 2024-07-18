<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Predis\Client;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\RedisConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeySaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyValueDriverFactoryInterface;

class RedisKeyValueDriverFactory implements KeyValueDriverFactoryInterface
{
    public function __construct(
        private readonly RedisConfigurationInterface $redisConfiguration,
    ) {
    }

    public function createKeyFinder(): KeyFinderInterface
    {
        return new RedisKeyFinder($this->createRedisClient());
    }

    public function createKeySaver(): KeySaverInterface
    {
        return new RedisKeySaver($this->createRedisClient());
    }

    private function createRedisClient(): Client
    {
        return new Client([
            'scheme' => $this->redisConfiguration->getScheme(),
            'host'   => $this->redisConfiguration->getHost(),
            'port'   => $this->redisConfiguration->getPort(),
        ]);
    }
}