<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeCollectionFinder::class;
    }
}