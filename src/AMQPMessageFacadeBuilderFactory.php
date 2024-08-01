<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;

class AMQPMessageFacadeBuilderFactory implements MessageBuilderFactoryInterface, AMQPMessageFacadeBuilderFactoryInterface
{
    public function __construct(
        private readonly AMQPMessageFacadeConfigurationInterface $amqpMessageFacadeConfiguration,
    ) {
    }

    public function createMessageBuilder(): MessageBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->amqpMessageFacadeConfiguration);
    }

    public function createAMQPMessageFacadeBuilder(): AMQPMessageFacadeBuilderInterface
    {
        return $this->createMessageBuilder();
    }
}