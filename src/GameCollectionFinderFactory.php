<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class GameCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return GameCollectionFinder::class;
    }
}