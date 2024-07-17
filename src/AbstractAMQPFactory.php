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
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublishingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

abstract class AbstractAMQPFactory implements CommandFactoryInterface
{
    protected LoggingSubscriberFactoryInterface $loggingSubscriberFactory;
    protected AMQPConnectionFactoryInterface $amqpConnectionFactory;
    protected PublishingSubscriberFactoryInterface $publishingSubscriberFactory;
    protected ConsumerFactoryInterface $consumerFactory;

    public function __construct(
        protected AMQPConnectionConfigurationInterface    $amqpConnectionConfiguration,
        protected AMQPConsumerConfigurationInterface      $consumerConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $receiverAmqpConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $publisherAmqpConfiguration,
        protected PublisherConfigurationInterface         $publisherConfiguration,
        protected LoggerConfigurationInterface            $loggerConfiguration,
    ) {
        $this->loggingSubscriberFactory = $this->createLoggerFactory();
        $this->amqpConnectionFactory = $this->createAMQPConnectionFactory();
        $this->publishingSubscriberFactory = $this->createPublishingSubscriberFactory();
        $this->consumerFactory = $this->createConsumerFactory();
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
            $this->createMessageProcessor(),
        );
    }

    public function createCommand(): CommandInterface
    {
        return new ConsumeCommand($this->consumerFactory->createConsumer());
    }

    abstract protected function createMessageProcessor(): MessageProcessorInterface;

    protected function createMessageProcessorEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::ModelFound,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelFound)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::ModelNotFound,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelNotFound)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::ModelSaveFailed,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelSaveFailed)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::ModelCreated,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelCreated)
        );

        $eventManager->subscribe(ProcessEventTypeEnum::ModelCreated, $this->publishingSubscriberFactory->createPublishingSubscriber());

        return $eventManager;
    }
}
