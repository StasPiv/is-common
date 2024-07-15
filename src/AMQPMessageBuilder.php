<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

class AMQPMessageBuilder implements AMQPMessageBuilderInterface
{
    public function buildAMQPMessage(StringInterface $model): AMQPMessage
    {
        return new AMQPMessage((string) $model);
    }
}