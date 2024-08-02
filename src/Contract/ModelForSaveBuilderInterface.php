<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ModelForSaveBuilderInterface
{
    public function buildModelForSave(ModelInCollectionInterface $model): void;
}
