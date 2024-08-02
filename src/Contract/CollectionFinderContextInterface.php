<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFinderContextInterface
{
    public function setStrategy(CollectionFinderInterface $strategy): void;

    public function findUnique(ModelInCollectionInterface $model): ?ModelInCollectionInterface;

    public function find(string $id): ?ModelInCollectionInterface;
}