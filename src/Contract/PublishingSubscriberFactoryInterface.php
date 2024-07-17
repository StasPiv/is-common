<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface PublishingSubscriberFactoryInterface
{
    public function createPublishingSubscriber(): SubscriberInterface;
}