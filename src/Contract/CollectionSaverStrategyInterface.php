<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionSaverStrategyInterface
{
    public function saveModel(ModelInCollectionInterface $model, string $collection): bool;
}