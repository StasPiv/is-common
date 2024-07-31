<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveCollectionSaverFactory extends AbstractCollectionSaverFactory
{
    protected function getCollectionSaverClassName(): string
    {
        return MoveCollectionSaver::class;
    }
}
