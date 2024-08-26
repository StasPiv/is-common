<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class TerminatorSubscriberFactory implements Contract\SubscriberFactoryInterface
{
    public function createSubscriber(): SubscriberInterface
    {
        return new TerminatorSubscriber();
    }
}