<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublishingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

abstract class AbstractAMQPFactory implements CommandFactoryInterface
{
    protected LoggingSubscriberFactoryInterface $loggingSubscriberFactory;
    protected AMQPConnectionFactoryInterface $amqpConnectionFactory;
    protected PublishingSubscriberFactoryInterface $publishingSubscriberFactory;

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

    public function createCommand(): CommandInterface
    {
        return new ConsumeCommand($this->createConsumer());
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

    private function createConsumer(): ConsumerInterface
    {
        return new AMQPConsumer(
            $this->amqpConnectionFactory->createAMQPConnection(),
            $this->amqpConnectionFactory->createAMQPChannel(),
            $this->createAMQPReceivedMessageFacadeBuilder(),
            $this->consumerConfiguration,
            $this->createMessageReceiver(),
        );
    }

    private function createMessageReceiver(): MessageReceiverInterface
    {
        return new MessageReceiver(
            $this->createReceiverEventManager(),
            $this->createMessageProcessor(),
        );
    }

    private function createAcknowledgingSubscriber(): SubscriberInterface
    {
        return new AcknowledgingSubscriber(
            $this->createAcknowledgingEventManager(),
        );
    }

    private function createAMQPReceivedMessageFacadeBuilder(): AMQPMessageFacadeBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->receiverAmqpConfiguration);
    }

    private function createReceiverEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessageReceived,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessageReceived)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Success,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::Success)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Fail,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::Fail)
        );
        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createAcknowledgingSubscriber());

        return $eventManager;
    }

    private function createAcknowledgingEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessageAcked,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessageAcked)
        );

        return $eventManager;
    }
}
