<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use PhpAmqpLib\Message\AMQPMessage;

interface AMQPMessageFacadeBuilderInterface
{
    public function buildMessageFromAmqpMessage(AMQPMessage $amqpMessage): MessageInterface;
}