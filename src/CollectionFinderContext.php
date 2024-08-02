<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class CollectionFinderContext implements CollectionFinderContextInterface
{
    private CollectionFinderInterface $strategy;

    public function setStrategy(CollectionFinderInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function findUnique(ModelInCollectionInterface $model): ?ModelInCollectionInterface
    {
        return $this->strategy->findUnique($model);
    }

    public function find(ModelInCollectionInterface $model): ?ModelInCollectionInterface
    {
        return $this->strategy->find($model);
    }
}