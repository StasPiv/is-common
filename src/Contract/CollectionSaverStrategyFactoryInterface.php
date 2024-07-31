<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionSaverStrategyFactoryInterface
{
    public function createSaverStrategy(): CollectionSaverStrategyInterface;
}