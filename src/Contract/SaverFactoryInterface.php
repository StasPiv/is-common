<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\AbstractAMQPToMysqlSaverFactory;
use StanislavPivovartsev\InterestingStatistics\Common\EventManager;
use StanislavPivovartsev\InterestingStatistics\Common\ProcessEventTypeEnum;

interface SaverFactoryInterface
{
    public function createConsumer(): ConsumerInterface;

    public function createPublisherMessageBuilder(): MessageBuilderInterface;

    public function createPublisher(): PublisherInterface;

    public function createCommand(): CommandInterface;

    public function createCollectionSavableModelBuilder(): CollectionSavableModelBuilderInterface;

    public function createCollectionFinder(): CollectionFinderInterface;

    public function createMessageModelDataValidator(): MessageModelDataValidatorInterface;

    public function createMessageModelFromStringBuilder(): MessageModelFromStringBuilderInterface;

    public function createCollectionSaver(): CollectionSaverInterface;

    public function createReceiverMessageProcessor(): MessageProcessorInterface;

    public function createPgnHashGenerator(): PgnHashGeneratorInterface;

    public function createIdGeneratorStrategy(): IdGeneratorStrategyInterface;

    public function createSavingProcessorEventManager(): EventManagerInterface;
}