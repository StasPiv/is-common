<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\UploadModel;

class UploadMongoCollectionFinder extends AbstractMongoCollectionFinder
{
    protected function getUniqueCriteria(ModelInCollectionInterface|UploadModel $model): array
    {
        return [
            'user' => $model->getUser(),
            'name' => $model->getName(),
        ];
    }

    public function getCollection(): string
    {
        return 'uploads';
    }

    /**
     * @inheritDoc
     */
    public function getModelInstanceClass(): string
    {
        return UploadModel::class;
    }
}