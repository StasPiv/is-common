<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueDeclareProcessorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueScannerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueScannerInterface;

class QueueScannerFactory implements QueueScannerFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface $amqpConnectionFactory,
        private readonly QueueDeclareProcessorFactoryInterface $queueDeclareProcessorFactory,
    ) {
    }

    public function createQueueScanner(): QueueScannerInterface
    {
        return new QueueScanner(
            $this->amqpConnectionFactory->createAMQPChannel(),
            $this->queueDeclareProcessorFactory->createQueueDeclareProcessor(),
        );
    }
}