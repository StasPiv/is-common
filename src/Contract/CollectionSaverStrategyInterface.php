<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionSaverStrategyInterface
{
    public function saveModel(string $collection, ModelInCollectionInterface $model): bool;
}