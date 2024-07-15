<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageFromAMQPMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;

class AMQPMessageFacadeBuilder implements MessageFromAMQPMessageBuilderInterface, MessageBuilderInterface
{
    public function __construct(
        private readonly AMQPMessageFacadeConfigurationInterface $configuration,
        private readonly AMQPMessageBuilderInterface $amqpMessageBuilder,
    ) {
    }

    public function buildMessageFromAmqpMessage(AMQPMessage $amqpMessage): MessageInterface
    {
        return new AMQPMessageFacade($amqpMessage, $this->configuration->getModelInstance());
    }

    public function buildMessageFromMessageModel(MessageModelInterface $messageModel): MessageInterface
    {
        $amqpMessage = $this->amqpMessageBuilder->buildAMQPMessage($messageModel);

        return $this->buildMessageFromAmqpMessage($amqpMessage);
    }
}
