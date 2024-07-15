<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;

class MysqlSelectQueryBuilder implements MysqlSelectQueryBuilderInterface
{
    public function __construct(
        private readonly \mysqli $mysqli,
    ) {
    }

    public function buildSelectSql(string $table, array $columns = ['*'], array $where = []): string
    {
        $columnsString = implode(', ', array_map(fn (string $column): string => "`$column`", $columns));
        $whereCondition = $this->buildWhereCondition($where);

        return "SELECT $columnsString FROM `$table` WHERE $whereCondition";
    }

    private function buildWhereCondition(array $where): string
    {
        if (count($where) === 0) {
            return '1';
        }

        $pairsArray = array_map(
            fn (string $value, string $key): string => "`$key` = '" . $this->mysqli->real_escape_string($value) . "'",
            $where,
            array_keys($where),
        );

        return implode(' AND ', $pairsArray);
    }
}