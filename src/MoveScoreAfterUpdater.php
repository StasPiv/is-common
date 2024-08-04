<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;
use StanislavPivovartsev\InterestingStatistics\Common\AbstractMoveScoreUpdater;

class MoveScoreAfterUpdater extends AbstractMoveScoreUpdater
{
    protected function updateScoreColumn(MoveScoreModel $moveScoreModel, int $score): void
    {
        $moveScoreModel->setScoreAfter((string) -$score);
    }

    protected function getFen(MoveMessageModel $moveSavableMessageModel): string
    {
        return $moveSavableMessageModel->getFenAfter();
    }

    protected function getScore(MoveScoreModel $moveScoreModel): ?int
    {
        return $moveScoreModel->getScoreAfter();
    }
}
