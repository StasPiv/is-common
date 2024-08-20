<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class LoggingSingleSubscriberFactory extends LoggingSubscriberFactory
{
    use IdentityMapTrait;

    public function createSubscriber(): SubscriberInterface
    {
        return $this->getFromIdentityMap(__FUNCTION__, func_get_args());
    }
}
