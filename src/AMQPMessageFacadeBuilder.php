<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

class AMQPMessageFacadeBuilder implements AMQPMessageFacadeBuilderInterface, MessageBuilderInterface
{
    public function __construct(
        private readonly AMQPMessageFacadeConfigurationInterface $configuration,
    ) {
    }

    public function buildMessageFromAmqpMessage(AMQPMessage $amqpMessage): MessageInterface
    {
        return new AMQPMessageFacade($amqpMessage, $this->configuration->getModelInstance());
    }

    public function buildMessageFromStringObject(StringInterface $stringObject): MessageInterface
    {
        $amqpMessage = new AMQPMessage((string) $stringObject);

        return $this->buildMessageFromAmqpMessage($amqpMessage);
    }
}
