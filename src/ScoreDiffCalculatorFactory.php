<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreDiffCalculatorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreDiffCalculatorInterface;

class ScoreDiffCalculatorFactory implements ScoreDiffCalculatorFactoryInterface
{
    public function createScoreDiffCalculator(): ScoreDiffCalculatorInterface
    {
        return new ScoreDiffCalculator();
    }
}
