<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MongoDatabaseFactoryInterface;

class GameExtMongoCollectionFinderFactory implements Contract\CollectionFinderFactoryInterface
{
    public function __construct(
        private readonly MongoDatabaseFactoryInterface $mongoDatabaseFactory,
    ) {
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new GameExtMongoCollectionFinder($this->mongoDatabaseFactory->createDatabase());
    }
}