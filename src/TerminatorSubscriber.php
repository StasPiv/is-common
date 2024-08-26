<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventTypeAwareProcessDataInterface;

class TerminatorSubscriber implements Contract\SubscriberInterface
{
    public function update(EventTypeAwareProcessDataInterface $processData): void
    {
        exit(1);
    }
}