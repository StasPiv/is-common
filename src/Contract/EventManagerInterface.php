<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

interface EventManagerInterface
{
    public function subscribe(ProcessEventTypeEnum $eventType, SubscriberInterface $subscriber): void;

    public function unsubscribe(ProcessEventTypeEnum $eventType, SubscriberInterface $subscriber): void;

    public function notify(ProcessEventTypeEnum $eventType, ProcessDataInterface $data): void;
}