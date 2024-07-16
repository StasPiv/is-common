<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class LoggingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface              $logger,
        private readonly ProcessEventTypeEnum $eventTypeEnum,
    ) {
    }

    public function update(ProcessDataInterface $processData): void
    {
        if ($this->eventTypeEnum === ProcessEventTypeEnum::Fail) {
            $this->logger->error($processData);

            return;
        }

        $this->logger->info($this->eventTypeEnum->name . ': ' . $processData);
    }
}
