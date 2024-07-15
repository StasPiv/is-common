<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionSaverInterface
{
    public function saveModel(ModelInCollectionInterface $model): bool;
}