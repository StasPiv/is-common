<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageReceiverInterface;

interface AMQPConsumerDriverFactoryInterface
{
    public function createAMQPConnection(): AMQPStreamConnection;

    public function createAMQPMessageBuilder(): AMQPMessageBuilderInterface;

    public function createAMQPChannel(): AMQPChannel;

    public function createAMQPMessageReceiver(): AMQPMessageReceiverInterface;
}