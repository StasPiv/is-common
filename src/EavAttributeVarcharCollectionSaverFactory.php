<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeVarcharCollectionSaverFactory extends AbstractCollectionSaverFactory
{
    protected function getCollectionSaverClassName(): string
    {
        return EavAttributeVarcharCollectionSaver::class;
    }
}