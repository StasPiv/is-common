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
        protected readonly MysqlConnectionInterface $mysqlConnection,
        protected readonly MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
    ) {
    }

    public function modelExists(array $criteria): bool
    {
        return $this->findOneBy($criteria) !== null;
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
        $modelInstance = $this->getModelInstance();

        return new $modelInstance(...$assoc);
    }
}