<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class EventManager implements EventManagerInterface
{
    /**
     * @var array<string, array<\StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface>>
     */
    private array $subscribers = [];

    public function subscribe(EventTypeInterface $eventType, SubscriberInterface $subscriber): void
    {
        $this->subscribers[$eventType->getName()][] = $subscriber;
    }

    public function unsubscribe(EventTypeInterface $eventType, SubscriberInterface $subscriber): void
    {
        if (($key = array_search($subscriber, $this->subscribers[$eventType->getName()])) !== false) {
            unset($this->subscribers[$eventType->getName()][$key]);
        }
    }

    public function notify(EventTypeInterface $eventType, ProcessDataInterface $data): void
    {
        if (!isset($this->subscribers[$eventType->getName()])) {
            return;
        }

        array_walk(
            $this->subscribers[$eventType->getName()],
            fn (SubscriberInterface $subscriber) => $subscriber->update($data),
        );
    }
}
