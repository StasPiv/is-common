<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface;

interface LoggerFactoryInterface
{
    public function createLoggingSubscriber(EventTypeInterface $eventType): SubscriberInterface;
}