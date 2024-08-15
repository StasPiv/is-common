<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlUpdateQueryBuilderInterface;

class MysqlStorageSaver implements StorageSaverInterface
{
    public function __construct(
        private readonly MysqlConnectionInterface         $mysqlConnection,
        private readonly CollectionFinderInterface        $collectionFinder,
        private readonly MysqlInsertQueryBuilderInterface $mysqlInsertQueryBuilder,
        private readonly MysqlUpdateQueryBuilderInterface $mysqlUpdateQueryBuilder,
        private readonly ModelForSaveBuilderInterface $modelForSaveBuilder,
    ) {
    }

    public function saveModel(string $collection, ModelInCollectionInterface $model): bool
    {
        $existingModel = $this->collectionFinder->findUnique($model);

        if ($existingModel) {
            $this->modelForSaveBuilder->buildModelForUpdate($model, $existingModel);
            $sql = $this->mysqlUpdateQueryBuilder->buildUpdateSql($collection, $model->getDataForSave(), ['id' => $model->getId()]);
        } else {
            $this->modelForSaveBuilder->buildModelForInsert($model);
            $data = $model->getDataForSave();
            $data['id'] = $model->getId();
            $sql = $this->mysqlInsertQueryBuilder->buildInsertSql($collection, $data);
        }

        return $this->mysqlConnection->queryForce($sql);
    }
}