<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MongoDatabaseFactoryInterface;

class UploadMongoCollectionFinderFactory implements CollectionFinderFactoryInterface
{
    public function __construct(
        private readonly MongoDatabaseFactoryInterface $mongoDatabaseFactory,
    ) {
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new UploadMongoCollectionFinder($this->mongoDatabaseFactory->createDatabase());
    }
}