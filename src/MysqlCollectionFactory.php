<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MysqliConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;

class MysqlCollectionFactory implements CollectionFactoryInterface
{
    public function __construct(
        protected MysqliConfigurationInterface $mysqliConfiguration,
    ) {
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new MysqlFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new MysqlSaver(
            $this->createMysqlConnection(),
            $this->createMysqlInsertQueryBuilder(),
        );
    }

    protected function createMysqlConnection(): MysqlConnectionInterface
    {
        return new MysqliFacadeConnection(
            $this->createMysqli(),
        );
    }

    protected function createMysqlInsertQueryBuilder(): MysqlInsertQueryBuilderInterface
    {
        return new MysqlInsertQueryBuilder($this->createMysqli());
    }

    protected function createMysqlSelectQueryBuilder(): MysqlSelectQueryBuilderInterface
    {
        return new MysqlSelectQueryBuilder($this->createMysqli());
    }

    private function createMysqli(): mysqli
    {
        return new mysqli(
            $this->mysqliConfiguration->getHost(),
            $this->mysqliConfiguration->getUserName(),
            $this->mysqliConfiguration->getPassword(),
            $this->mysqliConfiguration->getDatabase()
        );
    }
}