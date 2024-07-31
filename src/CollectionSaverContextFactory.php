<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextInterface;

class CollectionSaverContextFactory implements Contract\CollectionSaverContextFactoryInterface
{
    public function createCollectionSaverContext(): CollectionSaverContextInterface
    {
        return new CollectionSaverContext();
    }
}