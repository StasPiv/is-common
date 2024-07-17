<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\EventTypeInterface;

class LoggerFactory implements LoggerFactoryInterface
{
    public function __construct(
        private readonly LoggerConfigurationInterface $loggerConfiguration,
    ) {
    }

    public function createLoggingSubscriber(EventTypeInterface $eventType): SubscriberInterface
    {
        return new LoggingSubscriber($this->createLogger(), $eventType);
    }

    protected function createLogger(): LoggerInterface
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