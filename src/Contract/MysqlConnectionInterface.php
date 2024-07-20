<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use mysqli_result;

interface MysqlConnectionInterface
{
    public function query(string $sql): mysqli_result|bool;

    public function getAffectedRows(): int;
}