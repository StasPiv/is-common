<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\CollectionFinderException;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\CollectionSaverException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractEavAttributeValueModel;

abstract class AbstractEavAttributeValueCollectionSaver extends AbstractCollectionSaver implements EavAttributeValueCollectionSaverInterface
{
    public function __construct(
        StorageSaverInterface        $storageSaver,
        private readonly CollectionFinderContextInterface $collectionFinderContext,
        private readonly CollectionFinderInterface $gameFinder,
        private readonly CollectionFinderInterface $eavAttributeFinder,
        private readonly CollectionFinderInterface $moveFinder,
    ) {
        parent::__construct($storageSaver);
    }

    public function saveModel(ModelInCollectionInterface|AbstractEavAttributeValueModel $model): bool
    {
        $entityFinder = match ($model->getEntityType()) {
            'game' => $this->gameFinder,
            'move' => $this->moveFinder,
            default => throw new CollectionFinderException('Unknown entity type: ' . $model->getEntityType()),
        };

        $this->collectionFinderContext->setStrategy($entityFinder);
        $entity = $this->collectionFinderContext->findUnique($model->getEntity());

        if (!$entity) {
            throw new CollectionSaverException('Impossible to save value, because entity is not found: ' . $entity);
        }

        $model->setEntity($entity);

        /** @var \StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeModel $attribute */
        $attribute = $this->eavAttributeFinder->findUnique($model->getAttribute());

        if (!$attribute) {
            throw new CollectionSaverException('Impossible to save value, because attribute is not found: ' . $attribute);
        }

        $model->setAttribute($attribute);

        return parent::saveModel($model);
    }
}
