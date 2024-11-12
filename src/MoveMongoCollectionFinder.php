<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;

class MoveMongoCollectionFinder extends AbstractMongoCollectionFinder
{
    protected function getUniqueCriteria(ModelInCollectionInterface|MoveMessageModel $model): array
    {
        return [
            'gameId' => $model->getGameId(),
            'moveNumber' => $model->getMoveNumber(),
            'side' => $model->getSide(),
        ];
    }

    public function getCollection(): string
    {
        return 'moves_ext';
    }

    public function getModelInstanceClass(): string
    {
        return MoveMessageModel::class;
    }
}