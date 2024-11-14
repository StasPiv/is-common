<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MongoDatabaseFactoryInterface;

class PlayerSimpleMongoCollectionFinderFactory implements Contract\CollectionFinderFactoryInterface
{
    public function __construct(
        private readonly MongoDatabaseFactoryInterface $mongoDatabaseFactory,
    ) {
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new PlayerMongoCollectionFinder($this->mongoDatabaseFactory->createDatabase(), true);
    }
}