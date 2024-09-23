<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AbstractChannel;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueCleanerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;

class QueueCleaner implements QueueCleanerInterface
{
    public function __construct(
        private readonly AbstractChannel $channel,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function cleanQueues(array $queues): void
    {
        foreach ($queues as $queue) {
            $this->channel->queue_delete($queue);
            $this->channel->queue_declare($queue, false, false, false, false);
            $this->channel->queue_purge($queue, true);
            $this->channel->basic_qos(0, 1, false);

            $this->eventManager->notify(
                ProcessEventTypeEnum::QueueCleaned,
                new DataAwareProcessDataModel(['queue' => $queue]),
            );
        }
    }

    public function deleteQueues(array $queues): void
    {
        foreach ($queues as $queue) {
            $this->channel->queue_delete($queue);

            $this->eventManager->notify(
                ProcessEventTypeEnum::QueueDeleted,
                new DataAwareProcessDataModel(['queue' => $queue]),
            );
        }
    }

    public function cleanUserQueues(array $queues, string $user): void
    {
        $this->cleanQueues($this->getUserQueues($queues, $user));
    }

    public function deleteUserQueues(array $queues, string $user): void
    {
        $this->deleteQueues($this->getUserQueues($queues, $user));
    }

    private function getUserQueues(array $queues, string $user): array
    {
        return array_map(
            fn (string $queue): string => $queue . '_' . $user,
            $queues,
        );
    }
}