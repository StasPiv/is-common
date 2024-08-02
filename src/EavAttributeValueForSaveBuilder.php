<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\CollectionFinderException;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\ModelForSaveBuilderException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractEavAttributeValueModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\EavAttributeModel;

class EavAttributeValueForSaveBuilder extends StandardModelForSaveBuilder
{
    public function __construct(
        IdGeneratorStrategyInterface $idGeneratorStrategy,
        private readonly CollectionFinderContextInterface $collectionFinderContext,
        private readonly CollectionFinderInterface $gameFinder,
        private readonly CollectionFinderInterface $eavAttributeFinder,
    ) {
        parent::__construct($idGeneratorStrategy);
    }


    public function buildModelForSave(ModelInCollectionInterface|AbstractEavAttributeValueModel $model): void
    {
        parent::buildModelForSave($model);

        $entityFinder = match ($model->getEntityType()) {
            'game' => $this->gameFinder,
            default => throw new CollectionFinderException('Unknown entity type: ' . $model->getEntityType()),
        };

        $this->collectionFinderContext->setStrategy($entityFinder);

        $entity = $this->collectionFinderContext->findUnique($model->getEntity());
        $attribute = $this->eavAttributeFinder->findUnique($model->getAttribute());

        if (!$entity instanceof ModelInCollectionInterface || !$attribute instanceof EavAttributeModel) {
            throw new ModelForSaveBuilderException(
                'EavAttributeValue requires both entity and attribute: ' . $model->getEntity() . ', ' . $model->getAttribute(),
            );
        }

        $model->setEntity($entity);
        $model->setAttribute($attribute);
    }
}