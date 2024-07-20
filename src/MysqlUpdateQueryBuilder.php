<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class MysqlUpdateQueryBuilder implements Contract\MysqlUpdateQueryBuilderInterface
{
    public function __construct(
        private readonly \mysqli $mysqli,
    ) {
    }

    public function buildUpdateSql(string $table, array $data, array $where): string
    {
        $pairs = $this->buildPairs($data);
        $whereCondition = $this->buildWhereCondition($where);

        return "UPDATE `$table` SET $pairs WHERE $whereCondition";
    }

    /**
     * @param array<string, string> $data
     */
    private function buildPairs(array $data): string
    {
        $savableValues = array_filter(
            $data,
            fn ($value): bool => $value !== null,
            ARRAY_FILTER_USE_BOTH,
        );

        $pairsArray = array_map(
            fn (string $value, string $key): string => "`$key` = '" . $this->mysqli->real_escape_string($value) . "'",
            $savableValues,
            array_keys($savableValues),
        );

        return implode(', ', $pairsArray);
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