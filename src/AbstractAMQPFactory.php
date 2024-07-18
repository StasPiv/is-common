<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublishingSubscriberFactoryInterface;

abstract class AbstractAMQPFactory implements CommandFactoryInterface
{
    protected LoggingSubscriberFactoryInterface $loggingSubscriberFactory;
    protected AMQPConnectionFactoryInterface $amqpConnectionFactory;
    protected PublishingSubscriberFactoryInterface $publishingSubscriberFactory;
    protected ConsumerFactoryInterface $consumerFactory;
    protected EventManagerFactoryInterface $messageProcessorEventManagerFactory;
    protected CommandFactoryInterface $consumeCommandFactory;

    public function __construct(
        protected AMQPConnectionConfigurationInterface    $amqpConnectionConfiguration,
        protected AMQPConsumerConfigurationInterface      $consumerConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $receiverAmqpConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $publisherAmqpConfiguration,
        protected PublisherConfigurationInterface         $publisherConfiguration,
        protected LoggerConfigurationInterface            $loggerConfiguration,
        protected MessageProcessorFactoryInterface $messageProcessorFactory,
    ) {
        $this->loggingSubscriberFactory = $this->createLoggerFactory();
        $this->amqpConnectionFactory = $this->createAMQPConnectionFactory();
        $this->publishingSubscriberFactory = $this->createPublishingSubscriberFactory();
        $this->consumerFactory = $this->createConsumerFactory();
        $this->messageProcessorEventManagerFactory = $this->createMessageProcessorEventManagerFactory();
        $this->consumeCommandFactory = $this->createConsumeCommandFactory();
    }

    protected function createLoggerFactory(): LoggingSubscriberFactoryInterface
    {
        return new LoggingSubscriberFactory($this->loggerConfiguration);
    }

    protected function createAMQPConnectionFactory(): AMQPConnectionFactoryInterface
    {
        return new AMQPConnectionFactory($this->amqpConnectionConfiguration);
    }

    protected function createPublishingSubscriberFactory(): PublishingSubscriberFactoryInterface
    {
        return new PublishingSubscriberFactory(
            $this->amqpConnectionFactory,
            $this->loggingSubscriberFactory,
            $this->publisherAmqpConfiguration,
            $this->publisherConfiguration,
        );
    }

    protected function createConsumerFactory(): ConsumerFactoryInterface
    {
        return new ConsumerFactory(
            $this->amqpConnectionFactory,
            $this->loggingSubscriberFactory,
            $this->consumerConfiguration,
            $this->receiverAmqpConfiguration,
            $this->messageProcessorFactory,
        );
    }

    protected function createMessageProcessorEventManagerFactory(): EventManagerFactoryInterface
    {
        return new MessageProcessorEventManagerFactory(
            $this->loggingSubscriberFactory,
            $this->publishingSubscriberFactory,
        );
    }

    protected function createConsumeCommandFactory(): CommandFactoryInterface
    {
        return new ConsumeCommandFactory($this->consumerFactory);
    }

    public function createCommand(): CommandInterface
    {
        return $this->consumeCommandFactory->createCommand();
    }

    abstract protected function createMessageProcessor(): MessageProcessorInterface;

    protected function createMessageProcessorEventManager(): EventManagerInterface
    {
        return $this->messageProcessorEventManagerFactory->createEventManager();
    }
}
