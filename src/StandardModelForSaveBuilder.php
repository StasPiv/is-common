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

    public function buildModelForSave(ModelInCollectionInterface $model): void
    {
        $model->setId($this->idGeneratorStrategy->generateId());
    }
}