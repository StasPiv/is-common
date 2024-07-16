<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface;
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
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

abstract class AbstractAMQPFactory implements CommandFactoryInterface
{
    protected LoggerFactoryInterface $loggerFactory;

    public function __construct(
        protected AMQPConnectionConfigurationInterface    $amqpConnectionConfiguration,
        protected AMQPConsumerConfigurationInterface      $consumerConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $receiverAmqpConfiguration,
        protected AMQPMessageFacadeConfigurationInterface $publisherAmqpConfiguration,
        protected PublisherConfigurationInterface         $publisherConfiguration,
        protected LoggerConfigurationInterface            $loggerConfiguration,
    ) {
        $this->loggerFactory = $this->createLoggerFactory();
    }

    protected function createAMQPConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $this->amqpConnectionConfiguration->getHost(),
            $this->amqpConnectionConfiguration->getPort(),
            $this->amqpConnectionConfiguration->getUser(),
            $this->amqpConnectionConfiguration->getPassword(),
        );
    }

    protected function createAMQPChannel(): AMQPChannel
    {
        return $this->createAMQPConnection()->channel();
    }

    protected function createLoggerFactory(): LoggerFactoryInterface
    {
        return new LoggerFactory($this->loggerConfiguration);
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
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelFound)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::ModelNotFound,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelNotFound)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::ModelSaveFailed,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelSaveFailed)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::ModelCreated,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::ModelCreated)
        );

        $eventManager->subscribe(ProcessEventTypeEnum::ModelCreated, $this->createPublishingSubscriber());

        return $eventManager;
    }

    private function createConsumer(): ConsumerInterface
    {
        return new AMQPConsumer(
            $this->createAMQPConnection(),
            $this->createAMQPChannel(),
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

    private function createAMQPPublishedMessageFacadeBuilder(): AMQPMessageFacadeBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->publisherAmqpConfiguration);
    }

    protected function createPublisher(): PublisherInterface
    {
        return new AMQPPublisher(
            $this->createAMQPChannel(),
            $this->publisherConfiguration->getQueue(),
            $this->createMessageModelFromMessageBuilder(),
        );
    }

    private function createReceiverEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessageReceived,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessageReceived)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Success,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::Success)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Fail,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::Fail)
        );
        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createAcknowledgingSubscriber());

        return $eventManager;
    }

    private function createPublisherEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessagePublished,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessagePublished)
        );

        return $eventManager;
    }

    private function createAcknowledgingEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessageAcked,
            $this->loggerFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessageAcked)
        );

        return $eventManager;
    }

    private function createMessageModelFromMessageBuilder(): MessageModelExtractorInterface
    {
        return new MessageModelExtractor($this->createMessageModelFromStringBuilder());
    }

    private function createMessageModelFromStringBuilder(): MessageModelFromStringBuilderInterface
    {
        return new MessageModelFromStringBuilder();
    }

    protected function createPublishingSubscriber(): SubscriberInterface
    {
        return new PublishingSubscriber(
            $this->createPublisher(),
            $this->createPublisherEventManager(),
            $this->createAMQPPublishedMessageFacadeBuilder(),
        );
    }
}