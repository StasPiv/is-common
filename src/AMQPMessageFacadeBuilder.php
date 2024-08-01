<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;

class AMQPMessageFacadeBuilder implements AMQPMessageFacadeBuilderInterface
{
    public function __construct(
        private readonly AMQPMessageFacadeConfigurationInterface $configuration,
    ) {
    }

    public function buildMessageFromAmqpMessage(AMQPMessage $amqpMessage): MessageInterface
    {
        return new AMQPMessageFacade($amqpMessage, $this->configuration->getModelInstance());
    }
}
