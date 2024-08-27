<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyValueDriverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;

class MoveScoreCollectionCachingSaverFactory implements Contract\CollectionSaverFactoryInterface
{
    public function __construct(
        private readonly StorageSaverFactoryInterface $storageSaverFactory,
        private readonly KeyValueDriverFactoryInterface $keyValueDriverFactory,
    ) {
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new MoveScoreCollectionCachingSaver(
            $this->storageSaverFactory->createStorageSaver(),
            $this->keyValueDriverFactory->createKeyFinder(),
            $this->keyValueDriverFactory->createKeySaver(),
        );
    }
}