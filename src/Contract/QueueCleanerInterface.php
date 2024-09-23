<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;
use StanislavPivovartsev\InterestingStatistics\Common\QueueCleaner;

interface QueueCleanerInterface
{
    public function cleanQueues(array $queues): void;

    public function cleanUserQueues(array $queues, string $user): void;

    public function deleteUserQueues(array $queues, string $user): void;

    public function deleteQueues(array $queues): void;
}