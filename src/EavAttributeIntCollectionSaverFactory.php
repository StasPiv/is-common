<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;

class EavAttributeIntCollectionSaverFactory implements CollectionSaverFactoryInterface
{
    public function __construct(
        private readonly StorageSaverFactoryInterface $storageSaverFactory,
    ) {
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new EavAttributeIntCollectionSaver(
            $this->storageSaverFactory->createStorageSaver(),
        );
    }
}