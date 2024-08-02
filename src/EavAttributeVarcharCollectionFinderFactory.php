<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeVarcharCollectionFinderFactory extends AbstractEavAttributeValueCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeVarcharCollectionFinder::class;
    }
}