<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use mysqli;

interface MysqliFactoryInterface
{
    public function createMysqli(): mysqli;
}