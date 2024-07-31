<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MysqlConnectionFactoryInterface
{
    public function createMysqlConnection(): MysqlConnectionInterface;
}