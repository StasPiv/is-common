<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

interface LoggerFactoryInterface
{
    public function createLoggingSubscriber(ProcessEventTypeEnum $processEventTypeEnum): SubscriberInterface;
}