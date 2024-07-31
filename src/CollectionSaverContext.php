<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class CollectionSaverContext implements CollectionSaverContextInterface
{
    private CollectionSaverStrategyInterface $collectionSaverStrategy;

    /**
     * @param \StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface $collectionSaverStrategy
     *
     * @return CollectionSaverContext
     */
    public function setStrategy(CollectionSaverStrategyInterface $collectionSaverStrategy): CollectionSaverContext
    {
        $this->collectionSaverStrategy = $collectionSaverStrategy;

        return $this;
    }

    public function processSaveModel(ModelInCollectionInterface $model, string $collection): bool
    {
        return $this->collectionSaverStrategy->saveModel($model, $collection);
    }
}