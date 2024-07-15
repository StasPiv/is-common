<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\MessagePublishedProcessData;

interface ProcessDataBuilderInterface
{
    public function buildMessageReceivedProcessData(MessageInterface $message): MessageReceivedProcessDataInterface;

    public function buildSuccessfulProcessData(MessageInterface $message, ModelInCollectionInterface $modelInCollection, string $infoMessage,): SuccessfulProcessDataInterface;

    public function buildFailedProcessData(MessageInterface $message, string $errorMessage): FailedProcessDataInterface;

    public function buildMessagePublishedProcessData(MessageInterface $message): MessagePublishedProcessDataInterface;
}