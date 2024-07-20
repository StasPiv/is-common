<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MysqlUpdateQueryBuilderInterface
{
    public function buildUpdateSql(string $table, array $data, array $where): string;
}