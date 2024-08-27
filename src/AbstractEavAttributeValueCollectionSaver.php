<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\CollectionSaverException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractEavAttributeValueModel;

abstract class AbstractEavAttributeValueCollectionSaver extends AbstractCollectionSaver implements EavAttributeValueCollectionSaverInterface
{
    public function __construct(
        StorageSaverInterface        $storageSaver,
        private readonly CollectionSaverInterface        $eavAttributeCollectionSaver,
        private readonly CollectionSaverContextInterface $entityCollectionSaverContext,
        private readonly CollectionSaverInterface        $gameCollectionSaver,
        private readonly CollectionSaverInterface        $moveCollectionSaver,
    ) {
        parent::__construct($storageSaver);
    }

    public function saveModel(ModelInCollectionInterface|AbstractEavAttributeValueModel $model): bool
    {
        $this->eavAttributeCollectionSaver->saveModel($model->getAttribute());

        $entitySaverStrategy = match ($model->getEntityType()) {
            'game' => $this->gameCollectionSaver,
            'move' => $this->moveCollectionSaver,
            default => throw new CollectionSaverException('Unknown saver entity type ' . $model->getEntityType()),
        };

        $this->entityCollectionSaverContext->setStrategy($entitySaverStrategy);
        $this->entityCollectionSaverContext->processSaveModel($model->getEntity());

        return parent::saveModel($model);
    }
}
