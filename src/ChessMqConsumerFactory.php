<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;

class ChessMqConsumerFactory extends ConsumerFactory implements Contract\ConsumerFactoryInterface
{
    public function __construct(
        AMQPConnectionFactoryInterface $amqpConnectionFactory,
        SubscriberFactoryInterface $loggingSubscriberFactory,
        AMQPConsumerConfigurationInterface $consumerConfiguration,
        MessageProcessorFactoryInterface $messageProcessorFactory,
        AMQPMessageFacadeBuilderFactoryInterface $amqpMessageFacadeBuilderFactory,
        array $successSubscriberFactories,
        private readonly AMQPConnectionConfigurationInterface $connectionConfiguration,
        private readonly AMQPMessageFacadeConfigurationInterface $messageFacadeConfiguration,
    ) {
        parent::__construct(
            $amqpConnectionFactory,
            $loggingSubscriberFactory,
            $consumerConfiguration,
            $messageProcessorFactory,
            $amqpMessageFacadeBuilderFactory,
            $successSubscriberFactories,
        );
    }

    public function createConsumer(): ConsumerInterface
    {
        return new ChessMqConsumer(
            $this->connectionConfiguration,
            $this->consumerConfiguration,
            $this->createMessageReceiver(),
            $this->messageFacadeConfiguration,
        );
    }
}