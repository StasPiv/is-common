<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MessageCountQueueDeclareProcessor implements Contract\QueueDeclareProcessorInterface
{
    public function processQueueDeclare(string $queue, int $messageCount, int $consumerCount): bool
    {
        return $messageCount > 0;
    }
}