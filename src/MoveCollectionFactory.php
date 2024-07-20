<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveCollectionFactory extends AbstractMysqlCollectionFactory
{
    protected function getCollectionFinderClassName(): string
    {
        return MoveCollectionFinder::class;
    }

    protected function getCollectionSaverClassName(): string
    {
        return MoveCollectionSaver::class;
    }
}
