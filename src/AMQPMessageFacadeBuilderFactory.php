<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;

class AMQPMessageFacadeBuilderFactory implements AMQPMessageFacadeBuilderFactoryInterface
{
    public function __construct(
        private readonly AMQPMessageFacadeConfigurationInterface $amqpMessageFacadeConfiguration,
    ) {
    }

    public function createAMQPMessageFacadeBuilder(): AMQPMessageFacadeBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->amqpMessageFacadeConfiguration);
    }
}