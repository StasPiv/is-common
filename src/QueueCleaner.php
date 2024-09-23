<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AbstractChannel;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueCleanerInterface;

class QueueCleaner implements QueueCleanerInterface
{
    public function __construct(
        private readonly AbstractChannel $channel,
    ) {
    }

    public function cleanQueues(array $queues): void
    {
        foreach ($queues as $queue) {
            $this->channel->queue_delete($queue);
            $this->channel->queue_declare($queue, false, false, false, false);
            $this->channel->queue_purge($queue, true);
            $this->channel->basic_qos(0, 1, false);
        }
    }
}