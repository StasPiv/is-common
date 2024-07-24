<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MysqliConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;

abstract class AbstractEavAttributeValueCollectionFactory extends AbstractMysqlCollectionFactory
    implements EavAttributeValueCollectionSaverFactoryInterface
{
    public function __construct(
        protected MysqliConfigurationInterface $mysqliConfiguration,
        private readonly IdGeneratorStrategyFactoryInterface $idGeneratorStrategyFactory,
    ) {
        parent::__construct($mysqliConfiguration);
    }

    public function createCollectionSaver(): EavAttributeValueCollectionSaverInterface
    {
        /** @var \StanislavPivovartsev\InterestingStatistics\Common\AbstractEavAttributeValueCollectionSaver $saverClassName */
        $saverClassName = $this->getCollectionSaverClassName();

        return new $saverClassName(
            $this->createMysqlConnection(),
            $this->createCollectionFinder(),
            $this->createMysqlInsertQueryBuilder(),
            $this->createMysqlUpdateQueryBuilder(),
            $this->idGeneratorStrategyFactory->createIdGeneratorStrategy(),
        );
    }
}