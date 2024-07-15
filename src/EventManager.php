<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class EventManager implements EventManagerInterface
{
    /**
     * @var array<string, array<\StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface>>
     */
    private array $subscribers = [];

    public function __construct()
    {
        $eventTypeSuccess = ProcessEventTypeEnum::Success;
        $this->subscribers[$eventTypeSuccess->name] = [];

        $eventTypeFail = ProcessEventTypeEnum::Fail;
        $this->subscribers[$eventTypeFail->name] = [];
    }

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

    public function notify(ProcessDataInterface $data): void
    {
        array_walk(
            $this->subscribers[$data->getEventType()->name],
            fn (SubscriberInterface $subscriber) => $subscriber->update($data),
        );
    }
}
