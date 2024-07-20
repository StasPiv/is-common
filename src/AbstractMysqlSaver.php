<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;

abstract class AbstractMysqlSaver implements CollectionSaverInterface
{
    public function __construct(
        private readonly MysqlConnectionInterface $mysqlConnection,
        private readonly MysqlInsertQueryBuilderInterface $mysqlInsertQueryBuilder,
    ) {
    }

    public function saveModel(ModelInCollectionInterface $model): bool
    {
        $sql = $this->mysqlInsertQueryBuilder->buildInsertSql($this->getCollection(), $model->getData());

        return $this->mysqlConnection->query($sql);
    }
}
