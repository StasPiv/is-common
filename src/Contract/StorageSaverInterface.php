<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface StorageSaverInterface
{
    public function saveModel(string $collection, ModelInCollectionInterface $model): bool;
}