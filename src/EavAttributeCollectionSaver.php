<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeModel;

class EavAttributeCollectionSaver extends AbstractMysqlSaver
{

    public function getCollection(): string
    {
        return 'eav_attribute';
    }

    public function getModelInstance(): string
    {
        return EavAttributeModel::class;
    }
}