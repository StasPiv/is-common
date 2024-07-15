<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;

class MysqliFacadeConnection implements MysqlConnectionInterface
{
    public function __construct(
        private readonly mysqli $mysqli
    ) {
    }

    public function query(string $sql): bool
    {
        return $this->mysqli->query($sql) !== false;
    }

    public function getAffectedRows(): int
    {
        return $this->mysqli->affected_rows;
    }
}
