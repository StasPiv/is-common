<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\FailedProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceivedProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SuccessfulProcessDataInterface;

class ProcessDataBuilder implements ProcessDataBuilderInterface
{
    public function buildSuccessfulProcessData(
        MessageInterface $message,
        ModelInCollectionInterface $modelInCollection,
        string $infoMessage,
    ): SuccessfulProcessDataInterface {
        return new SuccessfulProcessData($message, $modelInCollection, $infoMessage);
    }

    public function buildFailedProcessData(MessageInterface $message, string $errorMessage): FailedProcessDataInterface
    {
        return new FailedProcessData($message, $errorMessage);
    }

    public function buildMessageReceivedProcessData(MessageInterface $message): MessageReceivedProcessDataInterface
    {
        return new MessageReceivedProcessData($message);
    }
}
