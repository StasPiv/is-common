<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

class GameMongoCollectionFinder extends AbstractMongoCollectionFinder
{
    public function getCollection(): string
    {
        return 'games_ext';
    }

    /**
     * @inheritDoc
     */
    public function getModelInstanceClass(): string
    {
        return GameMessageModel::class;
    }

    protected function getUniqueCriteria(ModelInCollectionInterface|GameMessageModel $model): array
    {
        return [
            'pgnHash' => $model->getPgnHash(),
        ];
    }
}