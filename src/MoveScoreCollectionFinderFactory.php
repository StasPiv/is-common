<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveScoreCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return MoveScoreCollectionFinder::class;
    }
}