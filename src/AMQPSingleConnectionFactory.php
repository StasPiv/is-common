<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;

class AMQPSingleConnectionFactory implements Contract\AMQPConnectionFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface $amqpConnectionFactory,
    ) {
    }

    public function createAMQPConnection(): AMQPStreamConnection
    {
        static $instance;

        if (isset($instance)) {
            return $instance;
        }

        return $instance = $this->amqpConnectionFactory->createAMQPConnection();
    }

    public function createAMQPChannel(): AMQPChannel
    {
        static $instance;

        if (isset($instance)) {
            return $instance;
        }

        return $instance = $this->amqpConnectionFactory->createAMQPChannel();
    }
}