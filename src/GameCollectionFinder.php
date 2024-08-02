<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

class GameCollectionFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'games';
    }

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