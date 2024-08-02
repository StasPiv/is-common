<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class MoveScoreCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'move_scores';
    }

    public function getModelInstanceClass(): string
    {
        return MoveScoreModel::class;
    }
}