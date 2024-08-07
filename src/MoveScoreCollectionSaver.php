<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class MoveScoreCollectionSaver extends AbstractCollectionSaver
{
    public function __construct(
        StorageSaverInterface        $storageSaver,
        private readonly CollectionSaverInterface $moveCollectionSaver,
    ) {
        parent::__construct($storageSaver);
    }


    public function getCollection(): string
    {
        return 'move_scores';
    }

    public function getModelInstanceClass(): string
    {
        return MoveScoreModel::class;
    }

    public function saveModel(ModelInCollectionInterface|MoveScoreModel $model): bool
    {
        $this->moveCollectionSaver->saveModel($model->getMove());

        return parent::saveModel($model);
    }
}