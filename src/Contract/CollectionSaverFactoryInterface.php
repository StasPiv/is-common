<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionSaverFactoryInterface
{
    public function createCollectionSaver(): CollectionSaverInterface;
}