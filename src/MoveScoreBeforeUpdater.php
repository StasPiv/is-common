<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;
use StanislavPivovartsev\InterestingStatistics\Common\AbstractMoveScoreUpdater;

class MoveScoreBeforeUpdater extends AbstractMoveScoreUpdater
{
    protected function updateScoreColumn(MoveScoreModel $moveScoreModel, int $score): void
    {
        $moveScoreModel->setScoreBefore((string) $score);
    }

    protected function getFen(MoveMessageModel $moveSavableMessageModel): string
    {
        return $moveSavableMessageModel->getFenBefore();
    }

    protected function getScore(MoveScoreModel $moveScoreModel): ?int
    {
        return $moveScoreModel->getScoreBefore();
    }
}