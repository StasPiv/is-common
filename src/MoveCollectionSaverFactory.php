<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;

class MoveCollectionSaverFactory implements CollectionSaverFactoryInterface
{
    public function __construct(
        private readonly StorageSaverFactoryInterface $storageSaverFactory,
        private readonly CollectionSaverFactoryInterface $gameCollectionSaverFactory,
    ) {
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new MoveCollectionSaver(
            $this->storageSaverFactory->createStorageSaver(),
            $this->gameCollectionSaverFactory->createCollectionSaver(),
        );
    }
}
