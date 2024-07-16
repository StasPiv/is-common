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
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandFactoryInterface;
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
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

abstract class AbstractAMQPToMysqlSaverFactory implements CommandFactoryInterface
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

    protected function createLogger(): LoggerInterface
    {
        $logger = new Logger($this->loggerConfiguration->getLogName());
        $logger->pushHandler(
            new StreamHandler('php://stdout',
                Level::fromName($this->loggerConfiguration->getLogLevel())
            )
        );

        return $logger;
    }

    public function createCommand(): CommandInterface
    {
        return new ConsumeCommand($this->createConsumer());
    }

    private function createMysqli(): mysqli
    {
        return new mysqli(
            $this->mysqliConfiguration->getHost(),
            $this->mysqliConfiguration->getUserName(),
            $this->mysqliConfiguration->getPassword(),
            $this->mysqliConfiguration->getDatabase()
        );
    }

    abstract protected function createMessageProcessor(): MessageProcessorInterface;

    protected function createMessageProcessorEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(ProcessEventTypeEnum::ModelFound, $this->createLoggingSubscriber(ProcessEventTypeEnum::ModelFound));
        $eventManager->subscribe(ProcessEventTypeEnum::ModelNotFound, $this->createLoggingSubscriber(ProcessEventTypeEnum::ModelNotFound));
        $eventManager->subscribe(ProcessEventTypeEnum::ModelSaveFailed, $this->createLoggingSubscriber(ProcessEventTypeEnum::ModelSaveFailed));
        $eventManager->subscribe(ProcessEventTypeEnum::ModelCreated, $this->createLoggingSubscriber(ProcessEventTypeEnum::ModelCreated));

        $eventManager->subscribe(ProcessEventTypeEnum::ModelCreated, $this->createPublishingSubscriber());

        return $eventManager;
    }

    protected function createCollectionFinder(): CollectionFinderInterface
    {
        return new MysqlFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
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

    protected function createIdGeneratorStrategy(): IdGeneratorStrategyInterface
    {
        return new UuidGeneratorStrategy();
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

        $eventManager->subscribe(ProcessEventTypeEnum::MessageReceived, $this->createLoggingSubscriber(ProcessEventTypeEnum::MessageReceived));
        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createLoggingSubscriber(ProcessEventTypeEnum::Success));
        $eventManager->subscribe(ProcessEventTypeEnum::Fail, $this->createLoggingSubscriber(ProcessEventTypeEnum::Fail));
        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createAcknowledgingSubscriber());

        return $eventManager;
    }

    private function createPublisherEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(ProcessEventTypeEnum::MessagePublished, $this->createLoggingSubscriber(ProcessEventTypeEnum::MessagePublished));

        return $eventManager;
    }

    private function createAcknowledgingEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(ProcessEventTypeEnum::MessageAcked, $this->createLoggingSubscriber(ProcessEventTypeEnum::MessageAcked));

        return $eventManager;
    }

    protected function createLoggingSubscriber(ProcessEventTypeEnum $processEventTypeEnum): SubscriberInterface
    {
        return new LoggingSubscriber($this->createLogger(), $processEventTypeEnum);
    }

    private function createMessageModelFromMessageBuilder(): MessageModelExtractorInterface
    {
        return new MessageModelExtractor($this->createMessageModelFromStringBuilder());
    }

    private function createMessageModelFromStringBuilder(): MessageModelFromStringBuilderInterface
    {
        return new MessageModelFromStringBuilder();
    }

    protected function createMysqlConnection(): MysqlConnectionInterface
    {
        return new MysqliFacadeConnection(
            $this->createMysqli(),
        );
    }

    protected function createMysqlInsertQueryBuilder(): MysqlInsertQueryBuilderInterface
    {
        return new MysqlInsertQueryBuilder($this->createMysqli());
    }

    protected function createCollectionSaver(): CollectionSaverInterface
    {
        return new MysqlSaver(
            $this->createMysqlConnection(),
            $this->createMysqlInsertQueryBuilder(),
        );
    }

    protected function createMysqlSelectQueryBuilder(): MysqlSelectQueryBuilderInterface
    {
        return new MysqlSelectQueryBuilder($this->createMysqli());
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