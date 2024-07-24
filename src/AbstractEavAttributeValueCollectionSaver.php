<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlUpdateQueryBuilderInterface;

abstract class AbstractEavAttributeValueCollectionSaver extends AbstractMysqlSaver implements EavAttributeValueCollectionSaverInterface
{
    public function __construct(
        protected MysqlConnectionInterface $mysqlConnection,
        protected CollectionFinderInterface $collectionFinder,
        protected MysqlInsertQueryBuilderInterface $mysqlInsertQueryBuilder,
        protected MysqlUpdateQueryBuilderInterface $mysqlUpdateQueryBuilder,
        private readonly IdGeneratorStrategyInterface $idGeneratorStrategy,
    ) {
        parent::__construct($this->mysqlConnection, $this->collectionFinder, $this->mysqlInsertQueryBuilder, $this->mysqlUpdateQueryBuilder);
    }

    public function saveEavAttributeValue(string $entityId, string $attributeId, mixed $value): void
    {
        /** @var \StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractEavAttributeValueModel $eavAttributeValueModel */
        $eavAttributeValueModel = $this->collectionFinder->findOneBy(
            [
                'entityId' => $entityId,
                'attributeId' => $attributeId
            ]
        );

        if ($eavAttributeValueModel) {
            return;
        }

        $modelClass = $this->getModelInstance();
        $eavAttributeValueModel = new $modelClass(
            $this->idGeneratorStrategy->generateId(),
            $entityId,
            $attributeId,
            $value,
        );

        $this->saveModel($eavAttributeValueModel);
    }
}
