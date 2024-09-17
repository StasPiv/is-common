<?php

use StanislavPivovartsev\InterestingStatistics\Common\AcknowledgingEventManagerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\AcknowledgingSubscriberFactory;
use StanislavPivovartsev\InterestingStatistics\Common\AMQPMessageFacadeBuilderFactory;
use StanislavPivovartsev\InterestingStatistics\Common\AMQPSingleConnectionFactory;
use StanislavPivovartsev\InterestingStatistics\Common\ChessMqConsumerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\ConsumeCommandFactory;
use StanislavPivovartsev\InterestingStatistics\Common\ConsumerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\LoggingSubscriberFactory;
use StanislavPivovartsev\InterestingStatistics\Common\Model\PgnSaveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\StandardLoggerFactory;

require_once 'vendor/autoload.php';

/** @var \StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface $amqpConnectionConfiguration */
$amqpConnectionConfiguration = new class implements AMQPConnectionConfigurationInterface {
    public function getHost(): string
    {
        return 'chess-analyze.online';
    }

    public function getPort(): int
    {
        return 5672;
    }

    public function getUser(): string
    {
        return 'InterestingStatistics';
    }

    public function getPassword(): string
    {
        return 'InterestingStatistics';
    }

};

$loggerConfiguration = new class implements LoggerConfigurationInterface {
    public function getLogName(): string
    {
        return 'rabbit-mq-consumer';
    }

    public function getLogLevel(): string
    {
        return 'debug';
    }
};

$consumerConfiguration = new class implements AMQPConsumerConfigurationInterface {
    public function getQueue(): string
    {
        return 'game';
    }
};

$messageProcessorFactory = new class implements MessageProcessorFactoryInterface {
    public function createMessageProcessor(): MessageProcessorInterface
    {
        return new class implements MessageProcessorInterface {
            public function process(MessageModelInterface|PgnSaveMessageModel $messageModel): void
            {
                echo 'dequeue game';
            }
        };
    }

};

$amqpConnectionFactory = new AMQPSingleConnectionFactory($amqpConnectionConfiguration);
$loggerFactory = new StandardLoggerFactory($loggerConfiguration);
$loggingSubscriberFactory = new LoggingSubscriberFactory($loggerFactory);

$amqpReceiverMessageFacadeConfiguration = new class implements AMQPMessageFacadeConfigurationInterface {
    public function getModelInstance(): string
    {
        return PgnSaveMessageModel::class;
    }
};

$amqpMessageFacadeBuilderFactory = new AMQPMessageFacadeBuilderFactory(
    $amqpReceiverMessageFacadeConfiguration,
);
$acknowledgingEventManagerFactory = new AcknowledgingEventManagerFactory($loggingSubscriberFactory);
$acknowledgingSubscriberFactory = new AcknowledgingSubscriberFactory($acknowledgingEventManagerFactory);

$consumerFactory = new ConsumerFactory(
    $amqpConnectionFactory,
    $loggingSubscriberFactory,
    $consumerConfiguration,
    $messageProcessorFactory,
    $amqpMessageFacadeBuilderFactory,
    [
        $acknowledgingSubscriberFactory,
    ],
);
$consumeCommandFactory = new ConsumeCommandFactory($consumerFactory);

$consumeCommandFactory->createCommand()->execute();
