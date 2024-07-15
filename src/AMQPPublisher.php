<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;

class AMQPPublisher implements PublisherInterface
{
    public function __construct(
        private readonly AMQPChannel                             $channel,
        private readonly string                                  $queue,
        private readonly AMQPMessageBuilderInterface             $messageBuilder,
        private readonly MessageModelFromMessageBuilderInterface $messageModelBuilder,
    ) {
    }

    public function publish(MessageInterface $message): void
    {
        $model = $this->messageModelBuilder->buildMessageModelFromMessage($message);

        $this->channel->basic_publish(
            $this->messageBuilder->buildAMQPMessage($model),
            '',
            $this->queue,
        );
    }
}