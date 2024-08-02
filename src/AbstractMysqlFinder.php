<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;

abstract class AbstractMysqlFinder implements CollectionFinderInterface
{
    public function __construct(
        protected MysqlConnectionInterface $mysqlConnection,
        protected MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
    ) {
    }

    public function findUnique(ModelInCollectionInterface $model): ?ModelInCollectionInterface
    {
        $criteria = $this->getUniqueCriteria($model);

        return $this->findOneBy($criteria);
    }

    public function find(string $id): ?ModelInCollectionInterface
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findOneBy(array $criteria): ?ModelInCollectionInterface
    {
        $sql = $this->mysqlSelectQueryBuilder->buildSelectSql(
            $this->getCollection(),
            ['*'],
            $criteria
        );

        $result = $this->mysqlConnection->query($sql);

        if ($result->num_rows === 0) {
            return null;
        }

        $assoc = $result->fetch_assoc();

        return $this->buildModelFromDb($assoc);
    }

    abstract protected function getUniqueCriteria(ModelInCollectionInterface $model): array;

    protected function buildModelFromDb(array $assoc): ModelInCollectionInterface
    {
        $id = $assoc['id'];
        unset($assoc['id']);

        $modelInstanceClass = $this->getModelInstanceClass();
        /** @var ModelInCollectionInterface $modelInstance */
        $modelInstance = new $modelInstanceClass(...$assoc);

        $modelInstance->setId($id);

        return $modelInstance;
    }
}