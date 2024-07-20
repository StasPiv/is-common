<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveScoreCollectionFactory extends AbstractMysqlCollectionFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return MoveScoreCollectionFinder::class;
    }

    protected function getCollectionSaverClassName(): string
    {
        return MoveScoreCollectionSaver::class;
    }
}