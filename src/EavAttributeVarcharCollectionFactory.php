<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeVarcharCollectionFactory extends AbstractEavAttributeValueCollectionFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeVarcharCollectionFinder::class;
    }

    protected function getCollectionSaverClassName(): string
    {
        return EavAttributeVarcharCollectionSaver::class;
    }
}