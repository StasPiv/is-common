<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class CollectionSaverContext implements CollectionSaverContextInterface
{
    private CollectionSaverInterface $collectionSaver;

    public function processSaveModel(ModelInCollectionInterface $model): bool
    {
        return $this->collectionSaver->saveModel($model);
    }

    public function setStrategy(CollectionSaverInterface $collectionSaver): static
    {
        $this->collectionSaver = $collectionSaver;

        return $this;
    }
}