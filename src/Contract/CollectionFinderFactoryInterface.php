<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFinderFactoryInterface
{
    public function createCollectionFinder(): CollectionFinderInterface;
}