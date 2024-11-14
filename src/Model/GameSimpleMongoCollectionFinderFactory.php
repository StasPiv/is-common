<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MongoDatabaseFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\GameMongoCollectionFinder;

class GameSimpleMongoCollectionFinderFactory implements CollectionFinderFactoryInterface
{
    public function __construct(
        private readonly MongoDatabaseFactoryInterface $mongoDatabaseFactory,
    ) {
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new GameMongoCollectionFinder($this->mongoDatabaseFactory->createDatabase(), true);
    }
}