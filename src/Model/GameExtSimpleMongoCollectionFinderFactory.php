<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MongoDatabaseFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\GameExtMongoCollectionFinder;

class GameExtSimpleMongoCollectionFinderFactory implements CollectionFinderFactoryInterface
{
    public function __construct(
        private readonly MongoDatabaseFactoryInterface $mongoDatabaseFactory,
    ) {
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new GameExtMongoCollectionFinder($this->mongoDatabaseFactory->createDatabase(), true);
    }
}