<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeVarcharModel;

class EavAttributeVarcharCollectionFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'eav_attribute_varchar';
    }

    public function getModelInstance(): string
    {
        return EavAttributeVarcharModel::class;
    }
}