<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;

class MysqlFinder implements CollectionFinderInterface
{
    public function __construct(
        private readonly MysqlConnectionInterface $mysqlConnection,
        private readonly MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
    ) {
    }

    public function modelExists(ModelInCollectionInterface $model): bool
    {
        $sql = $this->mysqlSelectQueryBuilder->buildSelectSql($model->getCollection(), ['id'], ['id' => $model->getId()]);
        $this->mysqlConnection->query($sql);

        return $this->mysqlConnection->getAffectedRows() > 0;
    }
}