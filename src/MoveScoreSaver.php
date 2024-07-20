<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MoveScoreSaver extends AbstractMysqlSaver
{
    public function getCollection(): string
    {
        return 'move_scores';
    }

    public function getModelInstance(): string
    {
        return MoveScoreSaver::class;
    }
}