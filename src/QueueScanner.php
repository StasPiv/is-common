<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueDeclareProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueScannerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\QueueScannerEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;

class QueueScanner implements QueueScannerInterface
{
    public function __construct(
        private readonly AMQPChannel           $channel,
        private readonly QueueDeclareProcessorInterface $queueDeclareProcessor,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function scanQueue(string $queue): void
    {
        do {
            list($queueName, $messageCount, $consumerCount) = $this->channel->queue_declare($queue, true);

            $this->eventManager->notify(
                QueueScannerEventTypeEnum::WaitForMessages,
                new DataAwareProcessDataModel(["queue" => $queue, "messageCount" => $messageCount, "consumerCount" => $consumerCount]),
            );

            $processResult = $this->queueDeclareProcessor->processQueueDeclare($queueName, $messageCount, $consumerCount);

            if (!$processResult) {
                break;
            }

            sleep(1);
        } while (true);
    }
}