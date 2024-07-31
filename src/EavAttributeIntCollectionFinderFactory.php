<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeIntCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeIntCollectionFinder::class;
    }
}