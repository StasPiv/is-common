<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeCollectionFactory extends AbstractMysqlCollectionFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeVarcharCollectionFinder::class;
    }

    protected function getCollectionSaverClassName(): string
    {
        return EavAttributeCollectionSaver::class;
    }
}