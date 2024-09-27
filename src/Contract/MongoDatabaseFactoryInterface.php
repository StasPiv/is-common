<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use MongoDB\Database;

interface MongoDatabaseFactoryInterface
{
    public function createDatabase(): Database;
}