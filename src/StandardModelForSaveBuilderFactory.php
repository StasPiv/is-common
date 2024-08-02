<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderInterface;

class StandardModelForSaveBuilderFactory implements Contract\ModelForSaveBuilderFactoryInterface
{
    public function __construct(
        private readonly IdGeneratorStrategyFactoryInterface $idGeneratorStrategyFactory,
    ) {
    }

    public function createModelForSaveBuilder(): ModelForSaveBuilderInterface
    {
        return new StandardModelForSaveBuilder($this->idGeneratorStrategyFactory->createIdGeneratorStrategy());
    }
}