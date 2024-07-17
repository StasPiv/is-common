<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;

class AMQPPublisher implements PublisherInterface
{
    public function __construct(
        private readonly AMQPChannel                    $channel,
        private readonly string                         $queue,
        private readonly MessageModelExtractorInterface $messageModelExtractor,
    ) {
    }

    public function publish(MessageInterface $message): void
    {
        $model = $this->messageModelExtractor->extractMessageModelFromMessage($message);

        $this->channel->basic_publish(
            new AMQPMessage((string) $model),
            '',
            $this->queue,
        );
    }
}