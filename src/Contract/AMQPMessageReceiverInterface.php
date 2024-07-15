<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use PhpAmqpLib\Message\AMQPMessage;

interface AMQPMessageReceiverInterface
{
    public function onReceiveAMQPMessage(AMQPMessage $amqpMessage): void;
}