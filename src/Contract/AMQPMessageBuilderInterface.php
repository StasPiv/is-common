<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

interface AMQPMessageBuilderInterface
{
    public function buildAMQPMessage(StringInterface $model): AMQPMessage;
}