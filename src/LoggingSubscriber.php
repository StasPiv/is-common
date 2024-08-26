<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventTypeAwareProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\PublisherEventTypeEnum;

class LoggingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface    $logger,
    ) {
    }

    public function update(EventTypeAwareProcessDataInterface $processData): void
    {
        $message = $processData->getEventType()->getName() . ': ' . $processData;

        if (in_array($processData->getEventType(), $this->getErrorEvents())) {
            $this->logger->error($message);

            return;
        }

        if (in_array($processData->getEventType(), $this->getInfoEvents())) {
            $this->logger->info($message);

            return;
        }

        $this->logger->debug($message);
    }

    private function getErrorEvents(): array
    {
        return [
            ProcessEventTypeEnum::Fail,
            ProcessEventTypeEnum::ModelSaveFailed,
            PublisherEventTypeEnum::PublishFail,
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
