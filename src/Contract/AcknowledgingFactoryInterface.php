<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface AcknowledgingFactoryInterface
{
    public function createAcknowledgingSubscriber(): SubscriberInterface;

    public function createAcknowledgingEventManager(): EventManagerInterface;
}