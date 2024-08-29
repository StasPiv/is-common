<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

interface ScoreDiffCalculatorInterface
{
    public function calculateDiff(MoveScoreModel $moveScoreModel): ?int;

    public function calculateAccuracy(MoveScoreModel $moveScoreModel): ?float;
}
