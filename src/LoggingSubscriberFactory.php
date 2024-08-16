<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class LoggingSubscriberFactory implements SubscriberFactoryInterface
{
    public function __construct(
        private readonly LoggerFactoryInterface $loggerFactory,
    ) {
    }

    public function createSubscriber(): SubscriberInterface
    {
        return new LoggingSubscriber($this->loggerFactory->createLogger());
    }
}