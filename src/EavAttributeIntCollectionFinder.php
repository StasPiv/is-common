<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeInt;

class EavAttributeIntCollectionFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'eav_attribute_int';
    }

    public function getModelInstance(): string
    {
        return EavAttributeInt::class;
    }
}