<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextInterface;

class CollectionFinderContextFactory implements Contract\CollectionFinderContextFactoryInterface
{
    public function createCollectionFinderContext(): CollectionFinderContextInterface
    {
        return new CollectionFinderContext();
    }
}