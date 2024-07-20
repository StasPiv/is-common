<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use mysqli_result;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;

class MysqliFacadeConnection implements MysqlConnectionInterface
{
    public function __construct(
        private readonly mysqli $mysqli
    ) {
    }

    public function query(string $sql): mysqli_result|bool
    {
        return $this->mysqli->query($sql);
    }

    public function getAffectedRows(): int
    {
        return $this->mysqli->affected_rows;
    }
}
