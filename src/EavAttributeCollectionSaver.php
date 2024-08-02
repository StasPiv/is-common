<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeModel;

class EavAttributeCollectionSaver extends AbstractCollectionSaver
{

    public function getCollection(): string
    {
        return 'eav_attributes';
    }

    public function getModelInstanceClass(): string
    {
        return EavAttributeModel::class;
    }
}