<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Model\DiffModel;

interface DiffEvaluatorInterface
{
    public function getDiff(string $fen, string $move): DiffModel;
}