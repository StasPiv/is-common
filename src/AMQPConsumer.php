<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageReceiverInterface;

class AMQPConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private readonly AMQPChannel $channel,
        private readonly AMQPMessageReceiverInterface $receiver,
        private readonly AMQPConsumerConfigurationInterface $configuration,
    ) {
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    public function consume(): void
    {
        $this->channel->basic_qos(0, 1, true);
        $this->channel->basic_consume($this->configuration->getQueue(), '', false, false, false, false, [$this->receiver, 'onReceiveAMQPMessage']);

        $this->channel->consume();

        $this->channel->close();
        $this->connection->close();
    }
}