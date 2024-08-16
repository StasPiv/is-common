<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;

class AMQPSingleConnectionFactory implements Contract\AMQPConnectionFactoryInterface
{
    private array $identityMap = [];

    public function __construct(
        private readonly AMQPConnectionFactoryInterface $amqpConnectionFactory,
    ) {
    }

    public function createAMQPConnection(): AMQPStreamConnection
    {
        if (isset($this->identityMap['connection'])) {
            return $this->identityMap['connection'];
        }

        return $this->identityMap['connection'] = $this->amqpConnectionFactory->createAMQPConnection();
    }

    public function createAMQPChannel(): AMQPChannel
    {
        if (isset($this->identityMap['channel'])) {
            return $this->identityMap['channel'];
        }

        return $this->identityMap['channel'] = $this->amqpConnectionFactory->createAMQPChannel();
    }
}