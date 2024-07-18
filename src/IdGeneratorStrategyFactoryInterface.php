<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;

interface IdGeneratorStrategyFactoryInterface
{
    public function createIdGeneratorStrategy(): IdGeneratorStrategyInterface;
}