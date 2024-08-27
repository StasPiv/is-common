<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeIntModel;

class EavAttributeIntCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'eav_attribute_int';
    }

    public function getModelInstanceClass(): string
    {
        return EavAttributeIntModel::class;
    }
}