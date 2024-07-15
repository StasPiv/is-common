<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageFromAMQPMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;

class AMQPMessageReceiver implements AMQPMessageReceiverInterface
{
    public function __construct(
        private readonly MessageFromAMQPMessageBuilderInterface $messageBuilder,
        private readonly MessageReceiverInterface $messageReceiver,
    ) {
    }

    public function onReceiveAMQPMessage(AMQPMessage $amqpMessage): void
    {
        $this->messageReceiver->onReceive($this->messageBuilder->buildMessageFromAmqpMessage($amqpMessage));
    }
}
