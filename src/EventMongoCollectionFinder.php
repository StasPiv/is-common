<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\EventMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

class EventMongoCollectionFinder extends AbstractMongoCollectionFinder
{
    protected function getUniqueCriteria(ModelInCollectionInterface|EventMessageModel $model): array
    {
        return [
            'name' => $model->getName(),
        ];
    }

    public function getCollection(): string
    {
        return 'events_ext';
    }

    public function getModelInstanceClass(): string
    {
        return EventMessageModel::class;
    }
}