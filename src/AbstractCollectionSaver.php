<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

abstract class AbstractCollectionSaver implements CollectionSaverInterface
{
    public function __construct(
        private readonly CollectionSaverContextInterface $collectionSaverContext,
        private readonly CollectionSaverStrategyInterface $collectionSaverStrategy,
    ) {
    }

    public function saveModel(ModelInCollectionInterface $model): bool
    {
        $this->collectionSaverContext->setStrategy($this->collectionSaverStrategy);

        return $this->collectionSaverContext->processSaveModel($model, $this->getCollection());
    }
}
