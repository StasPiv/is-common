<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;

class AMQPMessageFacade implements MessageInterface
{
    public function __construct(
        private readonly AMQPMessage             $amqpMessage,
        private readonly string                  $modelInstance,
    ) {
    }

    public function ack(): void
    {
        $this->amqpMessage->ack();
    }

    public function getModelInstance(): string
    {
        return $this->modelInstance;
    }

    public function __toString(): string
    {
        return $this->amqpMessage->getBody();
    }
}