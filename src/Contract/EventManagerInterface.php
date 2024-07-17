<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface;

interface EventManagerInterface
{
    public function subscribe(EventTypeInterface $eventType, SubscriberInterface $subscriber): void;

    public function unsubscribe(EventTypeInterface $eventType, SubscriberInterface $subscriber): void;

    public function notify(EventTypeInterface $eventType, ProcessDataInterface $data): void;
}