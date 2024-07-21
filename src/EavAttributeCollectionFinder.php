<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeModel;

class EavAttributeCollectionFinder extends AbstractMysqlFinder
{

    public function getCollection(): string
    {
        return 'eav_attributes';
    }

    public function getModelInstance(): string
    {
        return EavAttributeModel::class;
    }
}