<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Enum\ScoreWorkerProcessTypeEnum;

class ScoreWorkerEventManagerFactory extends MessageProcessorEventManagerFactory
{
    protected function getLoggingSubscriberEvents() : array
    {
        $events = parent::getLoggingSubscriberEvents();

        $newEvents = [
            ScoreWorkerProcessTypeEnum::ScoreExists,
            ScoreWorkerProcessTypeEnum::ScoreNotExists,
            ScoreWorkerProcessTypeEnum::ScoreNotProcessed,
        ];

        return array_merge($newEvents, $events);
    }
}