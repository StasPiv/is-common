<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;

class AMQPConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private readonly AMQPChannel $channel,
        private readonly AMQPMessageFacadeBuilderInterface $amqpMessageFacadeBuilder,
        private readonly AMQPConsumerConfigurationInterface $configuration,
        private readonly MessageReceiverInterface $messageReceiver,
    ) {
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    public function consume(): void
    {
        $this->channel->queue_declare(
            $this->configuration->getQueue(),
            false,
            false,
            false,
            false
        );

        $this->channel->basic_qos(0, 1, true);
        $this->channel->basic_consume(
            $this->configuration->getQueue(),
            '',
            false,
            false,
            false,
            false,
            fn (AMQPMessage $amqpMessage) => $this->messageReceiver->onReceive($this->amqpMessageFacadeBuilder->buildMessageFromAmqpMessage($amqpMessage))
        );

        $this->channel->consume();

        $this->channel->close();
        $this->connection->close();
    }
}
