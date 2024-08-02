<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderInterface;

class MoveScoreModelForSaveBuilderFactory implements Contract\ModelForSaveBuilderFactoryInterface
{
    public function __construct(
        private readonly IdGeneratorStrategyFactoryInterface $idGeneratorStrategyFactory,
        private readonly CollectionFinderFactoryInterface    $moveCollectionFinderFactory,
    ) {
    }

    public function createModelForSaveBuilder(): ModelForSaveBuilderInterface
    {
        return new MoveScoreModelForSaveBuilder(
            $this->idGeneratorStrategyFactory->createIdGeneratorStrategy(),
            $this->moveCollectionFinderFactory->createCollectionFinder(),
        );
    }
}