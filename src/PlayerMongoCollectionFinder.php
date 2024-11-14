<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\PlayerModel;

class PlayerMongoCollectionFinder extends AbstractMongoCollectionFinder
{
    protected function getUniqueCriteria(ModelInCollectionInterface|PlayerModel $model): array
    {
        return [
            'name' => $model->getName(),
            'fideId' => $model->getFideId(),
        ];
    }

    public function getCollection(): string
    {
        return 'players';
    }

    public function getModelInstanceClass(): string
    {
        return PlayerModel::class;
    }
}