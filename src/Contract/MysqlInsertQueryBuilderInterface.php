<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MysqlInsertQueryBuilderInterface
{
    public function buildInsertSql(string $table, array $data): string;
}
