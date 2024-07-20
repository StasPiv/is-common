<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class GameCollectionFactory extends AbstractMysqlCollectionFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return GameCollectionFinder::class;
    }

    protected function getCollectionSaverClassName(): string
    {
        return GameCollectionSaver::class;
    }
}
