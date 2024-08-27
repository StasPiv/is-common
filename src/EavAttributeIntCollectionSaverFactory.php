<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;

class EavAttributeIntCollectionSaverFactory implements CollectionSaverFactoryInterface
{
    public function __construct(
        private readonly StorageSaverFactoryInterface $storageSaverFactory,
        private readonly CollectionSaverFactoryInterface $eavAttributeCollectionSaverFactory,
        private readonly CollectionSaverContextFactoryInterface $entityCollectionSaverContext,
        private readonly CollectionSaverFactoryInterface $gameCollectionSaverFactory,
        private readonly CollectionSaverFactoryInterface $moveCollectionSaverFactory,
    ) {
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new EavAttributeIntCollectionSaver(
            $this->storageSaverFactory->createStorageSaver(),
            $this->eavAttributeCollectionSaverFactory->createCollectionSaver(),
            $this->entityCollectionSaverContext->createCollectionSaverContext(),
            $this->gameCollectionSaverFactory->createCollectionSaver(),
            $this->moveCollectionSaverFactory->createCollectionSaver(),
        );
    }
}