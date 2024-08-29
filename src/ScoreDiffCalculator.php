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

        return $this->getBaseDiffWithCoefficient($moveScoreModel, 600);

    }

    public function calculateAccuracy(MoveScoreModel $moveScoreModel): ?float
    {
        if ($moveScoreModel->getScoreBefore() === null || $moveScoreModel->getScoreAfter() === null) {
            return null;
        }

        $coefficient = 280;

        $baseDiff = $this->getBaseDiffWithCoefficient($moveScoreModel, $coefficient);

        if ($baseDiff === 0) {
            return 100;
        }

        return ($coefficient + $baseDiff) / ($coefficient / 100);
    }

    private function getBaseDiffWithCoefficient(MoveScoreModel $moveScoreModel, int $coefficient): int
    {
        // if I anyway win
        $scoreBefore = $moveScoreModel->getScoreBefore() > $coefficient / 2 ? $coefficient / 2 : $moveScoreModel->getScoreBefore();
        // if I anyway lose
        $scoreAfter = $moveScoreModel->getScoreAfter() < -$coefficient / 2 ? -$coefficient / 2 : $moveScoreModel->getScoreAfter();

        $baseDiff = $scoreAfter - $scoreBefore;

        if ($baseDiff < -$coefficient) {
            return -$coefficient;
        }

        if ($baseDiff > 0) {
            return 0;
        }

        return $baseDiff;
    }
}
