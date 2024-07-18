<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MysqliConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;

abstract class AbstractAMQPToMysqlSaverFactory extends AbstractAMQPFactory implements CommandFactoryInterface
{
    protected CollectionFactoryInterface $mysqlCollectionFactory;

    public function __construct(
        protected AMQPConnectionConfigurationInterface    $amqpConnectionConfiguration,
        protected AMQPConsumerConfigurationInterface      $consumerConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $receiverAmqpConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $publisherAmqpConfiguration,
        protected PublisherConfigurationInterface         $publisherConfiguration,
        protected LoggerConfigurationInterface            $loggerConfiguration,
        protected MysqliConfigurationInterface            $mysqliConfiguration,
    ) {
        parent::__construct(
            $this->amqpConnectionConfiguration,
            $this->consumerConfiguration,
            $this->receiverAmqpConfiguration,
            $this->publisherAmqpConfiguration,
            $this->publisherConfiguration,
            $this->loggerConfiguration,
        );

        $this->mysqlCollectionFactory = $this->createCollectionFactory();
    }

    protected function createCollectionFactory(): CollectionFactoryInterface
    {
        return new MysqlCollectionFactory($this->mysqliConfiguration);
    }

    abstract protected function createMessageProcessor(): MessageProcessorInterface;

    protected function createCollectionFinder(): CollectionFinderInterface
    {
        return $this->mysqlCollectionFactory->createCollectionFinder();
    }

    protected function createCollectionSaver(): CollectionSaverInterface
    {
        return $this->mysqlCollectionFactory->createCollectionSaver();
    }
}