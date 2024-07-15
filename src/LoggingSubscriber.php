<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\FailedProcessDataInterface;
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

    public function update(ProcessDataInterface $data): void
    {
        if ($data instanceof FailedProcessDataInterface) {
            $this->logger->error($data->getErrorMessage());

            return;
        }

        if ($data instanceof SuccessfulProcessDataInterface) {
            $this->logger->info($data->getInfoMessage() . ': ' . $data->getModelInCollection());
        }

        if ($data instanceof MessageReceivedProcessDataInterface) {
            $this->logger->info('Message received: ' . $data->getMessage());
        }
    }
}
