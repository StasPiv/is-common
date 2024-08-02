<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class StandardModelForSaveBuilder implements ModelForSaveBuilderInterface
{
    public function __construct(
        protected IdGeneratorStrategyInterface $idGeneratorStrategy,
    ) {
    }

    public function buildModelForInsert(ModelInCollectionInterface $model): void
    {
        $model->setId($this->idGeneratorStrategy->generateId());
    }

    public function buildModelForUpdate(ModelInCollectionInterface $model, ModelInCollectionInterface $existingModel): void
    {
        $model->setId($existingModel->getId());
    }
}