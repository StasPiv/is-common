<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

class EavAttributeMongoCollectionFinder extends AbstractMongoCollectionFinder
{
    protected function getUniqueCriteria(ModelInCollectionInterface|EavAttributeModel $model): array
    {
        return [
            'name' => $model->getName(),
        ];
    }

    public function getCollection(): string
    {
        return 'eav_attributes';
    }

    public function getModelInstanceClass(): string
    {
        return EavAttributeModel::class;
    }
}
