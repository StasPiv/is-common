<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;

class GameUserCollectionSaverFactory implements Contract\CollectionSaverFactoryInterface
{
    public function __construct(
        private readonly StorageSaverFactoryInterface $storageSaverFactory,
    ) {
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new GameUserCollectionSaver(
            $this->storageSaverFactory->createStorageSaver(),
        );
    }
}