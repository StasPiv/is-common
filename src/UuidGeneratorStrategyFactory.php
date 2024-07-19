<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;

class UuidGeneratorStrategyFactory implements IdGeneratorStrategyFactoryInterface
{
    public function createIdGeneratorStrategy(): IdGeneratorStrategyInterface
    {
        return new UuidGeneratorStrategy();
    }
}
