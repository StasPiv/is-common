<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFactoryInterface
{
    public function createCollectionFinder(): CollectionFinderInterface;

    public function createCollectionSaver(): CollectionSaverInterface;
}