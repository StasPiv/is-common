<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface DiffEvaluatorFactoryInterface
{
    public function createDiffEvaluator(): DiffEvaluatorInterface;
}