<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ReceiverFactoryInterface
{
    public function createReceiverMessageProcessor(): MessageProcessorInterface;

    public function createReceiverMessageProcessorEventManager(): EventManagerInterface;

    public function createReceiverEventManager(): EventManagerInterface;

    public function createAcknowledgingSubscriber(): SubscriberInterface;

    public function createLoggingSubscriber(): SubscriberInterface;

    public function createReceiverMessageBuilder(): MessageBuilderInterface;

    public function createMessageReceiver(): MessageReceiverInterface;
}