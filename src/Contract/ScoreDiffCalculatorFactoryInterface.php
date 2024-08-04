<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreDiffCalculatorInterface;

interface ScoreDiffCalculatorFactoryInterface
{
    public function createScoreDiffCalculator(): ScoreDiffCalculatorInterface;
}