<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFinderInterface
{
    public function modelExists(ModelInCollectionInterface $model): bool;
}