<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MysqliConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqliFactoryInterface;

class MysqliFactory implements MysqliFactoryInterface
{
    public function __construct(
        private readonly MysqliConfigurationInterface $mysqliConfiguration,
    ) {
    }

    public function createMysqli(): mysqli
    {
        static $mysqli;

        if ($mysqli) {
            return $mysqli;
        }

        return $mysqli = new mysqli(
            $this->mysqliConfiguration->getHost() . ':' . $this->mysqliConfiguration->getPort(),
            $this->mysqliConfiguration->getUserName(),
            $this->mysqliConfiguration->getPassword(),
            $this->mysqliConfiguration->getDatabase(),
            $this->mysqliConfiguration->getPort(),
        );
    }
}