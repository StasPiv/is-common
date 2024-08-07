<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionSaverContextInterface
{
    public function processSaveModel(ModelInCollectionInterface $model): bool;

    public function setStrategy(CollectionSaverInterface $collectionSaver): static;
}