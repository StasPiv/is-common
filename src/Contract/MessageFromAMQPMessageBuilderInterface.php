<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;

interface MessageFromAMQPMessageBuilderInterface
{
    public function buildMessageFromAmqpMessage(AMQPMessage $amqpMessage): MessageInterface;
}