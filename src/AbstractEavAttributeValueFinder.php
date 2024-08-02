<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\CollectionFinderException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractEavAttributeValueModel;

abstract class AbstractEavAttributeValueFinder extends AbstractMysqlFinder
{
    public function __construct(
        MysqlConnectionInterface $mysqlConnection,
        MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
        private readonly CollectionFinderContextInterface $collectionFinderContext,
        private readonly CollectionFinderInterface $gameFinder,
        private readonly CollectionFinderInterface $eavAttributeFinder,
    ) {
        parent::__construct($mysqlConnection, $mysqlSelectQueryBuilder);
    }

    protected function getUniqueCriteria(ModelInCollectionInterface|AbstractEavAttributeValueModel $model): array
    {
        $entityFinder = match ($model->getEntityType()) {
            'game' => $this->gameFinder,
            default => throw new CollectionFinderException('Unknown entity type: ' . $model->getEntityType()),
        };

        $this->collectionFinderContext->setStrategy($entityFinder);
        $entity = $this->collectionFinderContext->findUnique($model->getEntity());

        $attribute = $this->eavAttributeFinder->findUnique($model->getAttribute());

        return [
            'entityId' => $entity->getId(),
            'attributeId' => $attribute->getId(),
        ];
    }
}