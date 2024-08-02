<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlUpdateQueryBuilderInterface;

class MysqlCollectionSaverStrategy implements CollectionSaverStrategyInterface
{
    public function __construct(
        private readonly MysqlConnectionInterface         $mysqlConnection,
        private readonly CollectionFinderInterface        $collectionFinder,
        private readonly MysqlInsertQueryBuilderInterface $mysqlInsertQueryBuilder,
        private readonly MysqlUpdateQueryBuilderInterface $mysqlUpdateQueryBuilder,
        private readonly IdGeneratorStrategyInterface $idGeneratorStrategy,
    ) {
    }

    public function saveModel(string $collection, ModelInCollectionInterface $model): bool
    {
        $existingModel = $this->collectionFinder->findUnique($model);

        if ($existingModel) {
            $model->setId($existingModel->getId());
            $sql = $this->mysqlUpdateQueryBuilder->buildUpdateSql($collection, $model->getData(), ['id' => $model->getId()]);
        } else {
            $model->setId($this->idGeneratorStrategy->generateId());
            $data = $model->getData();
            $data['id'] = $model->getId();
            $sql = $this->mysqlInsertQueryBuilder->buildInsertSql($collection, $data);
        }

        return $this->mysqlConnection->query($sql);
    }
}