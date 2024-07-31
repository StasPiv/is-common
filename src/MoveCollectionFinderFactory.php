<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return MoveCollectionFinder::class;
    }
}