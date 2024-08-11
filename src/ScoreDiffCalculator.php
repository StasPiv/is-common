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

        // if I anyway win
        $scoreBefore = $moveScoreModel->getScoreBefore() > 300 ? 300 : $moveScoreModel->getScoreBefore();
        // if I anyway lose
        $scoreAfter = $moveScoreModel->getScoreAfter() < -300 ? -300 : $moveScoreModel->getScoreAfter();

        $baseDiff = $scoreAfter - $scoreBefore;

        if ($baseDiff < -600) {
            return -600;
        }

        if ($baseDiff > 0) {
            return 0;
        }

        return $baseDiff;
    }
}
