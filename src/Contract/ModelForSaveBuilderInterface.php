<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ModelForSaveBuilderInterface
{
    public function buildModelForInsert(ModelInCollectionInterface $model): void;

    public function buildModelForUpdate(ModelInCollectionInterface $model, ModelInCollectionInterface $existingModel): void;
}
