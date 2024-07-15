<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;

class MysqlInsertQueryBuilder implements MysqlInsertQueryBuilderInterface
{
    public function __construct(
        private readonly mysqli $mysqli,
    ) {
    }

    public function buildInsertSql(string $table, array $data): string
    {
        $pairs = $this->buildPairs($data);

        return "INSERT INTO `$table` SET $pairs";
    }

    /**
     * @param array<string, string> $data
     */
    private function buildPairs(array $data): string
    {
        $pairsArray = array_map(
            fn (string $value, string $key): string => "`$key` = '" . $this->mysqli->real_escape_string($value) . "'",
            $data,
            array_keys($data),
        );

        return implode(', ', $pairsArray);
    }
}
