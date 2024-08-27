<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use mysqli_result;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use Throwable;

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

    /**
     * @throws \Throwable
     */
    public function queryForce(string $sql): mysqli_result|bool
    {
        try {
            return $this->mysqli->query($sql);
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function getAffectedRows(): int
    {
        return $this->mysqli->affected_rows;
    }
}
