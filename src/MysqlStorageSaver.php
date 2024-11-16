<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;

class MysqlStorageSaver implements StorageSaverInterface
{
    public function __construct(
        private readonly MysqlConnectionInterface         $mysqlConnection,
        private readonly MysqlInsertQueryBuilderInterface $mysqlInsertQueryBuilder,
        private readonly ModelForSaveBuilderInterface $modelForSaveBuilder,
    ) {
    }

    public function saveModel(string $collection, ModelInCollectionInterface $model, bool $update = false): bool
    {
        $data = $model->getDataForSave();

        if (!isset($data['id'])) {
            $this->modelForSaveBuilder->buildModelForInsert($model);
            $data['id'] = $model->getId();
        }

        $sql = $this->mysqlInsertQueryBuilder->buildInsertSql($collection, $data);

        return $this->mysqlConnection->queryForce($sql);
    }
}