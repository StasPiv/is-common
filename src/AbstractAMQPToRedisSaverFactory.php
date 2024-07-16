<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Predis\Client;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\RedisConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeySaverInterface;

abstract class AbstractAMQPToRedisSaverFactory extends AbstractAMQPFactory
{
    public function __construct(
        protected AMQPConnectionConfigurationInterface    $amqpConnectionConfiguration,
        protected AMQPConsumerConfigurationInterface      $consumerConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $receiverAmqpConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $publisherAmqpConfiguration,
        protected PublisherConfigurationInterface         $publisherConfiguration,
        protected LoggerConfigurationInterface            $loggerConfiguration,
        protected RedisConfigurationInterface $redisConfiguration,
    ) {
        parent::__construct(
            $this->amqpConnectionConfiguration,
            $this->consumerConfiguration,
            $this->receiverAmqpConfiguration,
            $this->publisherAmqpConfiguration,
            $this->publisherConfiguration,
            $this->loggerConfiguration,
        );
    }

    protected function createRedisClient(): Client
    {
        return new Client([
            'scheme' => $this->redisConfiguration->getScheme(),
            'host'   => $this->redisConfiguration->getHost(),
            'port'   => $this->redisConfiguration->getPort(),
        ]);
    }

    protected function createKeyFinder(): KeyFinderInterface
    {
        return new RedisKeyFinder($this->createRedisClient());
    }

    protected function createKeySaver(): KeySaverInterface
    {
        return new RedisKeySaver($this->createRedisClient());
    }
}