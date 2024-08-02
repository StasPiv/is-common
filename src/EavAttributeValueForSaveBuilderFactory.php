<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderInterface;

class EavAttributeValueForSaveBuilderFactory implements Contract\ModelForSaveBuilderFactoryInterface
{
    public function __construct(
        private readonly IdGeneratorStrategyFactoryInterface $idGeneratorStrategyFactory,
        private readonly CollectionFinderContextFactoryInterface $collectionFinderContextFactory,
        private readonly CollectionFinderFactoryInterface $gameFinderFactory,
        private readonly CollectionFinderFactoryInterface $eavAttributeFinderFactory,
    ) {
    }

    public function createModelForSaveBuilder(): ModelForSaveBuilderInterface
    {
        return new EavAttributeValueForSaveBuilder(
            $this->idGeneratorStrategyFactory->createIdGeneratorStrategy(),
            $this->collectionFinderContextFactory->createCollectionFinderContext(),
            $this->gameFinderFactory->createCollectionFinder(),
            $this->eavAttributeFinderFactory->createCollectionFinder(),
        );
    }
}