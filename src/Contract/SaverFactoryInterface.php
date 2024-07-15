<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use Psr\Log\LoggerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\AbstractAMQPToMysqlSaverFactory;
use StanislavPivovartsev\InterestingStatistics\Common\EventManager;
use StanislavPivovartsev\InterestingStatistics\Common\ProcessEventTypeEnum;

interface SaverFactoryInterface
{
    public function createPublisherMessageBuilder(): MessageBuilderInterface;

    public function createPublisher(): PublisherInterface;

    public function createCollectionSavableModelBuilder(): CollectionSavableModelBuilderInterface;

    public function createCollectionFinder(): CollectionFinderInterface;

    public function createCollectionSaver(): CollectionSaverInterface;

    public function createPgnHashGenerator(): PgnHashGeneratorInterface;

    public function createIdGeneratorStrategy(): IdGeneratorStrategyInterface;
}