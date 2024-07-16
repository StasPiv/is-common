<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class EventManager implements EventManagerInterface
{
    /**
     * @var array<string, array<\StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface>>
     */
    private array $subscribers = [];

    public function subscribe(ProcessEventTypeEnum $eventType, SubscriberInterface $subscriber): void
    {
        $this->subscribers[$eventType->name][] = $subscriber;
    }

    public function unsubscribe(ProcessEventTypeEnum $eventType, SubscriberInterface $subscriber): void
    {
        if (($key = array_search($subscriber, $this->subscribers[$eventType->name])) !== false) {
            unset($this->subscribers[$eventType->name][$key]);
        }
    }

    public function notify(ProcessEventTypeEnum $eventType, ProcessDataInterface $data): void
    {
        if (!isset($this->subscribers[$eventType->name])) {
            return;
        }

        array_walk(
            $this->subscribers[$eventType->name],
            fn (SubscriberInterface $subscriber) => $subscriber->update($data),
        );
    }
}
