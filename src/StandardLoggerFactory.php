<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;

class StandardLoggerFactory implements Contract\LoggerFactoryInterface
{
    public function __construct(
        private readonly LoggerConfigurationInterface $loggerConfiguration,
    ) {
    }

    public function createLogger(): LoggerInterface
    {
        $logger = new Logger($this->loggerConfiguration->getLogName());
        $logger->pushHandler(
            new StreamHandler('php://stdout',
                Level::fromName($this->loggerConfiguration->getLogLevel())
            )
        );

        return $logger;
    }
}
