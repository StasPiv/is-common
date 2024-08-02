<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeIntCollectionFinderFactory extends AbstractEavAttributeValueCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeIntCollectionFinder::class;
    }
}