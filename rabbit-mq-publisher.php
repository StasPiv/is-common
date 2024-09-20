<?php

declare(strict_types = 1);

use StanislavPivovartsev\InterestingStatistics\Common\AMQPConnectionFactory;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\LoggingSubscriberFactory;
use StanislavPivovartsev\InterestingStatistics\Common\MessageProcessorEventManagerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\Model\PgnSaveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\PublishAvailableQueueDeclareProcessorFactory;
use StanislavPivovartsev\InterestingStatistics\Common\PublisherEventManagerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\PublisherFactory;
use StanislavPivovartsev\InterestingStatistics\Common\PublishingSingleItemSubscriberFactory;
use StanislavPivovartsev\InterestingStatistics\Common\PublishingSubscriberEventManagerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\QueueScannerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\StandardLoggerFactory;
use StanislavPivovartsev\InterestingStatistics\Common\TerminatorSubscriberFactory;

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
/** @var \StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface $publisherConfiguration */
$publisherConfiguration = new class implements PublisherConfigurationInterface {
    public function getQueue(): string
    {
        return 'game';
    }
};
/** @var \StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\LoggerConfigurationInterface $loggerConfiguration */
$loggerConfiguration = new class implements LoggerConfigurationInterface {
    public function getLogName(): string
    {
        return 'rabbit-mq-publisher';
    }

    public function getLogLevel(): string
    {
        return 'debug';
    }
};
/** @var \StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueBatchConfigurationInterface $queueBatchConfiguration */
$queueBatchConfiguration = new class implements QueueBatchConfigurationInterface {
    public function getBatchSize(string $queue): int
    {
        return 0;
    }

    public function getQueueSizeLimit(string $queue): int
    {
        return 999999;
    }

    public function isForce(): bool
    {
        return true;
    }

};
$amqpConnectionFactory = new AMQPConnectionFactory($amqpConnectionConfiguration);

$loggerFactory = new StandardLoggerFactory($loggerConfiguration);
$loggingSubscriberFactory = new LoggingSubscriberFactory($loggerFactory);
$terminatorSubscriberFactory = new TerminatorSubscriberFactory();
$publisherEventManagerFactory = new PublisherEventManagerFactory($loggingSubscriberFactory, $terminatorSubscriberFactory);
$publishAvailableQueueDeclareProcessorFactory = new PublishAvailableQueueDeclareProcessorFactory($queueBatchConfiguration, $publisherEventManagerFactory);
$queueScannerFactory = new QueueScannerFactory(
    $amqpConnectionFactory,
    $publishAvailableQueueDeclareProcessorFactory,
    $publisherEventManagerFactory,
);
$publisherFactory = new PublisherFactory(
    $amqpConnectionFactory,
    $publisherConfiguration,
    $publisherEventManagerFactory,
    $queueBatchConfiguration,
    $queueScannerFactory,
);

$publishingSubscriberEventManagerFactory = new PublishingSubscriberEventManagerFactory($loggingSubscriberFactory);

$publishingSubscriberFactory = new PublishingSingleItemSubscriberFactory(
    $publisherFactory,
    $publishingSubscriberEventManagerFactory,
);

$eventManagerFactory = new MessageProcessorEventManagerFactory($loggingSubscriberFactory, $publishingSubscriberFactory);

$publisherFactory = new PublisherFactory(
    $amqpConnectionFactory,
    $publisherConfiguration,
    $publisherEventManagerFactory,
    $queueBatchConfiguration,
    $queueScannerFactory,
);

$publisher = $publisherFactory->createPublisher();

$pgn = '[Event "Rated Blitz game"]
[Site "https://lichess.org/fqtZWSwI"]
[Date "2021.06.15"]
[White "buky85"]
[Black "SomeCM"]
[Result "1-0"]
[UTCDate "2021.06.15"]
[UTCTime "19:23:55"]
[WhiteElo "2380"]
[BlackElo "2376"]
[WhiteRatingDiff "+6"]
[BlackRatingDiff "-6"]
[Variant "Standard"]
[TimeControl "180+0"]
[ECO "B20"]
[Opening "Sicilian Defense: Snyder Variation"]
[Termination "Normal"]

1. e4 c5 2. b3 Nc6 1-0';

$moveSavable = new PgnSaveMessageModel($pgn);

while (true) {
    $publisher->publish($moveSavable);
    usleep(500000);
}