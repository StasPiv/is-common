<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveEvaluationModel;

interface MoveEvaluatorInterface
{
    public function getMoveEvaluation(string $fen, string $move): ?MoveEvaluationModel;
}