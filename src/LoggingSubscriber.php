<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\FailedProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageAckedProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceivedProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SuccessfulProcessDataInterface;

class LoggingSubscriber implements SubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface              $logger,
    ) {
    }

    public function update(ProcessDataInterface $processData): void
    {
        if ($processData instanceof FailedProcessDataInterface) {
            $this->logger->error($processData->getErrorMessage());

            return;
        }

        if ($processData instanceof SuccessfulProcessDataInterface) {
            $this->logger->info($processData->getInfoMessage() . ': ' . $processData->getModelInCollection());
        }

        if ($processData instanceof MessageReceivedProcessDataInterface) {
            $this->logger->info('Message received: ' . $processData->getMessage());
        }

        if ($processData instanceof MessagePublishedProcessData) {
            $this->logger->info('Message published: ' . $processData->getMessage());
        }

        if ($processData instanceof MessageAckedProcessDataInterface) {
            $this->logger->info('Message acked: ' . $processData->getMessage());
        }
    }
}
