<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;

class EavAttributeVarcharCollectionSaverFactory implements CollectionSaverFactoryInterface
{
    public function __construct(
        private readonly StorageSaverFactoryInterface $storageSaverFactory,
        private readonly CollectionFinderContextFactoryInterface $collectionFinderContextFactory,
        private readonly CollectionFinderFactoryInterface $gameCollectionFinderFactory,
        private readonly CollectionFinderFactoryInterface $eavAttributeCollectionFinderFactory,
        private readonly CollectionFinderFactoryInterface $moveCollectionFinderFactory,
    ) {
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new EavAttributeVarcharCollectionSaver(
            $this->storageSaverFactory->createStorageSaver(),
            $this->collectionFinderContextFactory->createCollectionFinderContext(),
            $this->gameCollectionFinderFactory->createCollectionFinder(),
            $this->eavAttributeCollectionFinderFactory->createCollectionFinder(),
            $this->moveCollectionFinderFactory->createCollectionFinder(),
        );
    }
}