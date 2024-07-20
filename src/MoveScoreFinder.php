<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class MoveScoreFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'move_scores';
    }

    public function getModelInstance(): string
    {
        return MoveScoreModel::class;
    }
}