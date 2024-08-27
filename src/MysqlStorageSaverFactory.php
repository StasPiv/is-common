<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelForSaveBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqliFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlUpdateQueryBuilderInterface;

class MysqlStorageSaverFactory implements StorageSaverFactoryInterface
{
    public function __construct(
        private readonly MysqlConnectionFactoryInterface $mysqlConnectionFactory,
        private readonly MysqliFactoryInterface $mysqliFactory,
        private readonly ModelForSaveBuilderFactoryInterface $modelForSaveBuilderFactory,
    ) {
    }

    public function createStorageSaver(): StorageSaverInterface
    {
        return new MysqlStorageSaver(
            $this->mysqlConnectionFactory->createMysqlConnection(),
            $this->createMysqlInsertQueryBuilder(),
            $this->modelForSaveBuilderFactory->createModelForSaveBuilder(),
        );
    }

    protected function createMysqlInsertQueryBuilder(): MysqlInsertQueryBuilderInterface
    {
        return new MysqlInsertQueryBuilder($this->mysqliFactory->createMysqli());
    }

    protected function createMysqlUpdateQueryBuilder(): MysqlUpdateQueryBuilderInterface
    {
        return new MysqlUpdateQueryBuilder($this->mysqliFactory->createMysqli());
    }
}