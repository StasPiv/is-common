<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeIntCollectionFactory extends AbstractMysqlCollectionFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return EavAttributeIntCollectionFinder::class;
    }

    protected function getCollectionSaverClassName(): string
    {
        return EavAttributeIntCollectionSaver::class;
    }
}