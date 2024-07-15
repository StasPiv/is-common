<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use mysqli;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;

interface MysqlStorageDriverFactoryInterface
{
    public function createMysqlConnection(): MysqlConnectionInterface;

    public function createMysqli(): mysqli;

    public function createMysqlInsertQueryBuilder(): MysqlInsertQueryBuilderInterface;

    public function createMysqlSelectQueryBuilder(): MysqlSelectQueryBuilderInterface;
}