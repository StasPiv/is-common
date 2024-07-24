<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeIntModel;

class EavAttributeIntCollectionSaver extends AbstractEavAttributeValueCollectionSaver
{
    public function getCollection(): string
    {
        return 'eav_attribute_int';
    }

    public function getModelInstance(): string
    {
        return EavAttributeIntModel::class;
    }
}