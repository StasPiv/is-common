<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqliFactoryInterface;

class MoveScoreCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    public function __construct(
        MysqlConnectionFactoryInterface                   $mysqlConnectionFactory,
        MysqliFactoryInterface                            $mysqliFactory,
        private readonly CollectionFinderFactoryInterface $moveCollectionFinderFactory,
    ) {
        parent::__construct($mysqlConnectionFactory, $mysqliFactory);
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        /** @var \StanislavPivovartsev\InterestingStatistics\Common\MoveCollectionFinder|class-string $finderClassName */
        $finderClassName = $this->getCollectionFinderClassName();

        return new $finderClassName(
            $this->mysqlConnectionFactory->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
            $this->moveCollectionFinderFactory->createCollectionFinder(),
        );
    }

    protected function getCollectionFinderClassName(): string
    {
        return MoveScoreCollectionFinder::class;
    }
}