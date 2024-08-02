<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderInterface;

class MoveModelForSaveBuilderFactory implements ModelForSaveBuilderFactoryInterface
{
    public function __construct(
        private readonly IdGeneratorStrategyFactoryInterface $idGeneratorStrategyFactory,
        private readonly CollectionFinderFactoryInterface $gameCollectionFinderFactory,
    ) {
    }

    public function createModelForSaveBuilder(): ModelForSaveBuilderInterface
    {
        return new MoveModelForSaveBuilder(
            $this->idGeneratorStrategyFactory->createIdGeneratorStrategy(),
            $this->gameCollectionFinderFactory->createCollectionFinder(),
        );
    }
}