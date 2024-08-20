<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventTypeAwareProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class LoggingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface    $logger,
    ) {
    }

    public function update(EventTypeAwareProcessDataInterface $processData): void
    {
        if (in_array($processData->getEventType(), $this->getErrorEvents())) {
            $this->logger->error($processData);

            return;
        }

        if (in_array($processData->getEventType(), $this->getInfoEvents())) {
            $this->logger->info($processData);

            return;
        }

        $this->logger->debug($processData->getEventType()->getName() . ': ' . $processData);
    }

    private function getErrorEvents(): array
    {
        return [
            ProcessEventTypeEnum::Fail,
            ProcessEventTypeEnum::ModelSaveFailed,
        ];
    }

    private function getInfoEvents(): array
    {
        return [
            ProcessEventTypeEnum::MessageReceived,
            ProcessEventTypeEnum::MessageAcked,
        ];
    }
}
