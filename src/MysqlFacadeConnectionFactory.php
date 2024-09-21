<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqliFactoryInterface;

class MysqlFacadeConnectionFactory implements MysqlConnectionFactoryInterface
{
    public function __construct(
        private readonly MysqliFactoryInterface $mysqliFactory,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createMysqlConnection(): MysqlConnectionInterface
    {
        return new MysqliFacadeConnection(
            $this->mysqliFactory->createMysqli(),
            $this->eventManagerFactory->createEventManager(),
        );
    }
}