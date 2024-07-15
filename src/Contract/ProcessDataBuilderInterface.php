<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ProcessDataBuilderInterface
{
    public function buildMessageReceivedProcessData(MessageInterface $message): MessageReceivedProcessDataInterface;

    public function buildSuccessfulProcessData(MessageInterface $message, ModelInCollectionInterface $modelInCollection, string $infoMessage,): SuccessfulProcessDataInterface;

    public function buildFailedProcessData(MessageInterface $message, string $errorMessage): FailedProcessDataInterface;

    public function buildMessagePublishedProcessData(MessageInterface $message): MessagePublishedProcessDataInterface;

    public function buildMessageAckedProcessData(MessageInterface $message): MessageAckedProcessDataInterface;
}