<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqliFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;

abstract class AbstractMysqlCollectionFinderFactory implements CollectionFinderFactoryInterface
{
    public function __construct(
        private readonly MysqlConnectionFactoryInterface $mysqlConnectionFactory,
        private readonly MysqliFactoryInterface $mysqliFactory,
    ) {
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        $finderClassName = $this->getCollectionFinderClassName();

        return new $finderClassName(
            $this->mysqlConnectionFactory->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }

    /**
     * @return class-string
     */
    abstract protected function getCollectionFinderClassName(): string;

    private function createMysqlSelectQueryBuilder(): MysqlSelectQueryBuilderInterface
    {
        return new MysqlSelectQueryBuilder($this->mysqliFactory->createMysqli());
    }
}