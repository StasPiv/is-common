<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EventMessageModel;

class EventCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'events';
    }

    public function getModelInstanceClass(): string
    {
        return EventMessageModel::class;
    }
}