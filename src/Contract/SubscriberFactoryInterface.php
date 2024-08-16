<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface SubscriberFactoryInterface
{
    public function createSubscriber(): SubscriberInterface;
}