<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqliFactoryInterface;

abstract class AbstractEavAttributeValueCollectionFinderFactory extends AbstractMysqlCollectionFinderFactory
{
    public function __construct(
        MysqlConnectionFactoryInterface $mysqlConnectionFactory,
        MysqliFactoryInterface $mysqliFactory,
        private readonly CollectionFinderContextFactoryInterface $collectionFinderContextFactory,
        private readonly CollectionFinderFactoryInterface $gameCollectionFinderFactory,
        private readonly CollectionFinderFactoryInterface $eavAttributeCollectionFinderFactory,
    ) {
        parent::__construct($mysqlConnectionFactory, $mysqliFactory);
    }

    public function createCollectionFinder(): CollectionFinderInterface
    {
        /** @var \StanislavPivovartsev\InterestingStatistics\Common\AbstractEavAttributeValueFinder|class-string $finderClassName */
        $finderClassName = $this->getCollectionFinderClassName();

        return new $finderClassName(
            $this->mysqlConnectionFactory->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
            $this->collectionFinderContextFactory->createCollectionFinderContext(),
            $this->gameCollectionFinderFactory->createCollectionFinder(),
            $this->eavAttributeCollectionFinderFactory->createCollectionFinder(),
        );
    }
}