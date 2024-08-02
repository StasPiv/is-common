<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeModel;

class EavAttributeCollectionFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'eav_attributes';
    }

    public function getModelInstanceClass(): string
    {
        return EavAttributeModel::class;
    }

    protected function getUniqueCriteria(ModelInCollectionInterface|EavAttributeModel $model): array
    {
        return [
            'name' => $model->getName(),
        ];
    }
}