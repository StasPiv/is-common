<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionSaverContextFactoryInterface
{
    public function createCollectionSaverContext(): CollectionSaverContextInterface;
}