<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MysqliConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;

abstract class AbstractMysqlCollectionFactory implements CollectionFactoryInterface
{
    public function __construct(
        protected MysqliConfigurationInterface $mysqliConfiguration,
    ) {
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