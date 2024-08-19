<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MoveEvaluatorFactoryInterface
{
    public function createMoveEvaluator(): MoveEvaluatorInterface;
}