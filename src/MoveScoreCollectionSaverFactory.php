<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveScoreCollectionSaverFactory extends AbstractCollectionSaverFactory
{
    protected function getCollectionSaverClassName(): string
    {
        return MoveScoreCollectionSaver::class;
    }
}