<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface;

class PublisherFactory implements PublisherFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface $amqpConnectionFactory,
        private readonly PublisherConfigurationInterface $publisherConfiguration,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
        private readonly QueueBatchConfigurationInterface $queueBatchConfiguration,
    ) {
    }

    public function createPublisher(): PublisherInterface
    {
        return new AMQPPublisher(
            $this->amqpConnectionFactory->createAMQPChannel(),
            $this->publisherConfiguration->getQueue(),
            $this->eventManagerFactory->createEventManager(),
            $this->queueBatchConfiguration,
        );
    }
}