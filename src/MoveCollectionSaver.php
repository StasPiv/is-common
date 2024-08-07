<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveSavableMessageModel;

class MoveCollectionSaver extends AbstractCollectionSaver
{
    public function __construct(
        StorageSaverInterface $storageSaver,
        private readonly CollectionSaverInterface $gameCollectionSaver,
    ) {
        parent::__construct($storageSaver);
    }

    public function getCollection(): string
    {
        return 'moves';
    }

    public function getModelInstanceClass(): string
    {
        return MoveSavableMessageModel::class;
    }

    public function saveModel(ModelInCollectionInterface|MoveMessageModel $model): bool
    {
        $this->gameCollectionSaver->saveModel($model->getGame());

        return parent::saveModel($model);
    }
}