<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MysqlSelectQueryBuilderInterface
{
    public function buildSelectSql(string $table, array $columns = ['*'], array $where = []): string;
}