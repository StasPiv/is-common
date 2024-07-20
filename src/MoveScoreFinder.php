<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveScoreFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'move_scores';
    }

    public function getModelInstance(): string
    {
        return MoveScoreFinder::class;
    }
}