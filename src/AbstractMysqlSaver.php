<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlUpdateQueryBuilderInterface;

abstract class AbstractMysqlSaver implements CollectionSaverInterface
{
    public function __construct(
        protected MysqlConnectionInterface $mysqlConnection,
        protected CollectionFinderInterface $collectionFinder,
        protected MysqlInsertQueryBuilderInterface $mysqlInsertQueryBuilder,
        protected MysqlUpdateQueryBuilderInterface $mysqlUpdateQueryBuilder,
    ) {
    }

    public function saveModel(ModelInCollectionInterface $model): bool
    {
        if (!$this->collectionFinder->find($model->getId())) {
            $sql = $this->mysqlInsertQueryBuilder->buildInsertSql($this->getCollection(), $model->getData());
        } else {
            $sql = $this->mysqlUpdateQueryBuilder->buildUpdateSql($this->getCollection(), $model->getData(), ['id' => $model->getId()]);
        }

        return $this->mysqlConnection->query($sql);
    }
}
