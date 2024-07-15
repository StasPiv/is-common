<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MysqlConnectionInterface
{
    public function query(string $sql): bool;

    public function getAffectedRows(): int;
}