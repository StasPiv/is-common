<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueDeclareProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueScannerInterface;

class QueueScanner implements QueueScannerInterface
{
    public function __construct(
        private readonly AMQPChannel           $channel,
        private readonly QueueDeclareProcessorInterface $queueDeclareProcessor,
    ) {
    }

    public function scanQueue(string $queue): void
    {
        do {
            list($queueName, $messageCount, $consumerCount) = $this->channel->queue_declare($queue, true);

            $processResult = $this->queueDeclareProcessor->processQueueDeclare($queueName, $messageCount, $consumerCount);

            sleep(1);
        } while ($processResult);
    }
}