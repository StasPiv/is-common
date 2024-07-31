<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\CollectionSaverContext;

interface CollectionSaverContextInterface
{
    public function processSaveModel(ModelInCollectionInterface $model, string $collection): bool;

    /**
     * @param \StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface $collectionSaverStrategy
     *
     * @return CollectionSaverContext
     */
    public function setStrategy(CollectionSaverStrategyInterface $collectionSaverStrategy): CollectionSaverContext;
}