<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

class AMQPPublisher implements PublisherInterface
{
    public function __construct(
        private readonly AMQPChannel                    $channel,
        private readonly string                         $queue,
    ) {
    }

    public function publish(StringInterface $model): void
    {
        $this->channel->basic_publish(
            new AMQPMessage((string) $model),
            '',
            $this->queue,
        );
    }
}