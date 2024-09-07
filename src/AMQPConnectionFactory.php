<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;

class AMQPConnectionFactory implements AMQPConnectionFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionConfigurationInterface $amqpConnectionConfiguration
    ) {
    }

    public function createAMQPConnection(): AMQPStreamConnection
    {
        try {
            return new AMQPStreamConnection(
                $this->amqpConnectionConfiguration->getHost(),
                $this->amqpConnectionConfiguration->getPort(),
                $this->amqpConnectionConfiguration->getUser(),
                $this->amqpConnectionConfiguration->getPassword(),
                '/',
                false,
                'AMQPLAIN',
                null,
                'en_US',
                300.0,
                300.0,
            );
        } catch (\Exception $e) {
            sleep(1);

            return $this->createAMQPConnection();
        }
    }

    public function createAMQPChannel(): AMQPChannel
    {
        return $this->createAMQPConnection()->channel();
    }
}
