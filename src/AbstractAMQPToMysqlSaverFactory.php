<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use mysqli;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AcknowledgingFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConsumerDriverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSavableModelBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MysqliConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelDataValidatorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlStorageDriverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PgnHashGeneratorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ReceiverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Factory\PublisherFactoryInterface;

abstract class AbstractAMQPToMysqlSaverFactory implements
    SaverFactoryInterface,
    MysqlStorageDriverFactoryInterface,
    AMQPConsumerDriverFactoryInterface,
    ReceiverFactoryInterface,
    PublisherFactoryInterface,
    AcknowledgingFactoryInterface,
    LoggerFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionConfigurationInterface    $amqpConnectionConfiguration,
        private readonly AMQPConsumerConfigurationInterface      $consumerConfiguration,
        private readonly AMQPMessageFacadeConfigurationInterface $receiverAmqpConfiguration,
        private readonly AMQPMessageFacadeConfigurationInterface $publisherAmqpConfiguration,
        private readonly PublisherConfigurationInterface         $publisherConfiguration,
        private readonly LoggerConfigurationInterface            $loggerConfiguration,
        private readonly MysqliConfigurationInterface            $mysqliConfiguration,
    ) {
    }

    public function createAcknowledgingSubscriber(): SubscriberInterface
    {
        return new AcknowledgingSubscriber(
            $this->createAcknowledgingEventManager(),
            $this->createProcessDataBuilder(),
        );
    }

    public function createAMQPMessageBuilder(): AMQPMessageBuilderInterface
    {
        return new AMQPMessageBuilder();
    }

    public function createAMQPConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $this->amqpConnectionConfiguration->getHost(),
            $this->amqpConnectionConfiguration->getPort(),
            $this->amqpConnectionConfiguration->getUser(),
            $this->amqpConnectionConfiguration->getPassword(),
        );
    }

    public function createAMQPChannel(): AMQPChannel
    {
        return $this->createAMQPConnection()->channel();
    }

    public function createAMQPMessageReceiver(): AMQPMessageReceiverInterface
    {
        return new AMQPMessageReceiver(
            $this->createReceiverMessageBuilder(),
            $this->createMessageReceiver(),
        );
    }

    public function createConsumer(): ConsumerInterface
    {
        return new AMQPConsumer(
            $this->createAMQPConnection(),
            $this->createAMQPChannel(),
            $this->createAMQPMessageReceiver(),
            $this->consumerConfiguration,
        );
    }

    public function createReceiverMessageBuilder(): MessageBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->receiverAmqpConfiguration, $this->createAMQPMessageBuilder());
    }

    public function createPublisherMessageBuilder(): MessageBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->publisherAmqpConfiguration, $this->createAMQPMessageBuilder());
    }

    public function createPublisher(): PublisherInterface
    {
        return new AMQPPublisher(
            $this->createAMQPChannel(),
            $this->publisherConfiguration->getQueue(),
            $this->createAMQPMessageBuilder(),
            $this->createMessageModelFromMessageBuilder(),
        );
    }

    public function createCommand(): CommandInterface
    {
        return new ConsumeCommand($this->createConsumer());
    }

    public function createReceiverEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(ProcessEventTypeEnum::MessageReceived, $this->createLoggingSubscriber());

        return $eventManager;
    }

    public function createPublisherEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(ProcessEventTypeEnum::MessagePublished, $this->createLoggingSubscriber());

        return $eventManager;
    }

    public function createAcknowledgingEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(ProcessEventTypeEnum::MessageAcked, $this->createLoggingSubscriber());

        return $eventManager;
    }

    public function createSavingProcessorEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createLoggingSubscriber());
        $eventManager->subscribe(ProcessEventTypeEnum::Fail, $this->createLoggingSubscriber());
        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createPublishingSubscriber());
        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createAcknowledgingSubscriber());

        return $eventManager;
    }

    public function createCollectionSavableModelBuilder(): CollectionSavableModelBuilderInterface
    {
        return new GameModelBuilder(
            $this->createIdGeneratorStrategy(),
            $this->createPgnHashGenerator(),
            $this->createMessageModelFromMessageBuilder(),
        );
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new GameModelFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }

    public function createLogger(): LoggerInterface
    {
        $logger = new Logger($this->loggerConfiguration->getLogName());
        $logger->pushHandler(new StreamHandler('php://stdout', Level::fromName($this->loggerConfiguration->getLogLevel())));

        return $logger;
    }

    public function createLoggingSubscriber(): SubscriberInterface
    {
        return new LoggingSubscriber(
            $this->createLogger()
        );
    }

    public function createMessageModelDataValidator(): MessageModelDataValidatorInterface
    {
        return new MessageModelDataValidator();
    }

    public function createMessageModelFromMessageBuilder(): MessageModelFromMessageBuilderInterface
    {
        return new MessageModelFromMessageBuilder($this->createMessageModelFromStringBuilder());
    }

    public function createMessageModelFromStringBuilder(): MessageModelFromStringBuilderInterface
    {
        return new MessageModelFromStringBuilder(
            $this->createMessageModelDataValidator()
        );
    }

    public function createMessageReceiver(): MessageReceiverInterface
    {
        return new MessageReceiver(
            $this->createReceiverEventManager(),
            $this->createReceiverMessageProcessor(),
            $this->createProcessDataBuilder(),
        );
    }

    public function createMysqlConnection(): MysqlConnectionInterface
    {
        return new MysqliFacadeConnection(
            $this->createMysqli(),
        );
    }

    public function createMysqli(): mysqli
    {
        return new mysqli(
            $this->mysqliConfiguration->getHost(),
            $this->mysqliConfiguration->getUserName(),
            $this->mysqliConfiguration->getPassword(),
            $this->mysqliConfiguration->getDatabase()
        );
    }

    public function createMysqlInsertQueryBuilder(): MysqlInsertQueryBuilderInterface
    {
        return new MysqlInsertQueryBuilder($this->createMysqli());
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new MysqlSaver(
            $this->createMysqlConnection(),
            $this->createMysqlInsertQueryBuilder(),
        );
    }

    public function createMysqlSelectQueryBuilder(): MysqlSelectQueryBuilderInterface
    {
        return new MysqlSelectQueryBuilder($this->createMysqli());
    }

    abstract protected function createPublisherMessageModelBuilder(): MessageModelFromProcessDataBuilderInterface;

    public function createProcessDataBuilder(): ProcessDataBuilderInterface
    {
        return new ProcessDataBuilder();
    }

    public function createPublishingSubscriber(): SubscriberInterface
    {
        return new PublishingSavedDataSubscriber(
            $this->createPublisher(),
            $this->createPublisherMessageModelBuilder(),
            $this->createPublisherMessageBuilder(),
            $this->createPublisherEventManager(),
            $this->createProcessDataBuilder(),
        );
    }

    public function createReceiverMessageProcessor(): MessageProcessorInterface
    {
        return new SavingMessageProcessor(
            $this->createCollectionSaver(),
            $this->createCollectionSavableModelBuilder(),
            $this->createCollectionFinder(),
            $this->createProcessDataBuilder(),
            $this->createSavingProcessorEventManager(),
        );
    }

    public function createPgnHashGenerator(): PgnHashGeneratorInterface
    {
        return new Sha1PgnHashGenerator();
    }

    public function createIdGeneratorStrategy(): IdGeneratorStrategyInterface
    {
        return new UuidGeneratorStrategy();
    }
}