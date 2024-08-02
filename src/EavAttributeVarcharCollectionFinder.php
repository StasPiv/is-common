<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeVarcharModel;

class EavAttributeVarcharCollectionFinder extends AbstractEavAttributeValueFinder
{
    public function getCollection(): string
    {
        return 'eav_attribute_varchar';
    }

    public function getModelInstanceClass(): string
    {
        return EavAttributeVarcharModel::class;
    }
}