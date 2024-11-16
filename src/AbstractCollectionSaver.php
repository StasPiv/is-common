<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;

abstract class AbstractCollectionSaver implements CollectionSaverInterface
{
    public function __construct(
        private readonly StorageSaverInterface        $storageSaver,
    ) {
    }

    public function saveModel(ModelInCollectionInterface $model, bool $update = false): bool
    {
        return $this->storageSaver->saveModel($this->getCollection(), $model, $update);
    }
}
