<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeVarcharCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeVarcharCollectionFinder::class;
    }
}