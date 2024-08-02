<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFinderContextFactoryInterface
{
    public function createCollectionFinderContext(): CollectionFinderContextInterface;
}
