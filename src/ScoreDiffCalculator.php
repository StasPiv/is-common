<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreDiffCalculatorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class ScoreDiffCalculator implements ScoreDiffCalculatorInterface
{
    public function calculateDiff(MoveScoreModel $moveScoreModel): ?int
    {
        if ($moveScoreModel->getScoreBefore() === null || $moveScoreModel->getScoreAfter() === null) {
            return null;
        }

        $baseDiff = $moveScoreModel->getScoreAfter() - $moveScoreModel->getScoreBefore();

        if ($baseDiff < -300) {
            return -300;
        }

        if ($baseDiff > 0) {
            return 0;
        }

        return $baseDiff;
    }
}
