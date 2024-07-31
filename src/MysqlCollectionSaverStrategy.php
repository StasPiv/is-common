<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface;
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
    ) {
    }

    public function saveModel(ModelInCollectionInterface $model, string $collection): bool
    {
        if (!$this->collectionFinder->find($model->getId())) {
            $sql = $this->mysqlInsertQueryBuilder->buildInsertSql($collection, $model->getData());
        } else {
            $sql = $this->mysqlUpdateQueryBuilder->buildUpdateSql($collection, $model->getData(), ['id' => $model->getId()]);
        }

        return $this->mysqlConnection->query($sql);
    }
}