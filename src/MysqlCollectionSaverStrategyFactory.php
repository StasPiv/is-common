<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqliFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlInsertQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlUpdateQueryBuilderInterface;

class MysqlCollectionSaverStrategyFactory implements CollectionSaverStrategyFactoryInterface
{
    public function __construct(
        private readonly CollectionFinderFactoryInterface $collectionFinderFactory,
        private readonly MysqlConnectionFactoryInterface $mysqlConnectionFactory,
        private readonly MysqliFactoryInterface $mysqliFactory,
        private readonly IdGeneratorStrategyFactoryInterface $idGeneratorStrategyFactory,
    ) {
    }

    public function createSaverStrategy(): CollectionSaverStrategyInterface
    {
        return new MysqlCollectionSaverStrategy(
            $this->mysqlConnectionFactory->createMysqlConnection(),
            $this->collectionFinderFactory->createCollectionFinder(),
            $this->createMysqlInsertQueryBuilder(),
            $this->createMysqlUpdateQueryBuilder(),
            $this->idGeneratorStrategyFactory->createIdGeneratorStrategy(),
        );
    }

    protected function createMysqlInsertQueryBuilder(): MysqlInsertQueryBuilderInterface
    {
        return new MysqlInsertQueryBuilder($this->mysqliFactory->createMysqli());
    }

    protected function createMysqlUpdateQueryBuilder(): MysqlUpdateQueryBuilderInterface
    {
        return new MysqlUpdateQueryBuilder($this->mysqliFactory->createMysqli());
    }
}