<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueCleanerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueCleanerInterface;

class QueueCleanerFactory implements QueueCleanerFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface $connectionFactory,
    ) {
    }

    public function createQueueCleaner(): QueueCleanerInterface
    {
        return new QueueCleaner($this->connectionFactory->createAMQPChannel());
    }
}