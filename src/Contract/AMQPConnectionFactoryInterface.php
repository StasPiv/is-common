<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

interface AMQPConnectionFactoryInterface
{
    public function createAMQPConnection(): AMQPStreamConnection;

    public function createAMQPChannel(): AMQPChannel;
}