<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

interface MoveScoreUpdaterInterface
{
    public function updateMoveScore(MoveScoreModel $moveScoreModel): void;
}