<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyFactoryInterface;

class EavAttributeValueCollectionSaverContextFactory implements EavAttributeValueCollectionSaverContextFactoryInterface
{
    public function __construct(
        private readonly IdGeneratorStrategyFactoryInterface $idGeneratorStrategyFactory,
    ) {
    }

    public function createContext(): EavAttributeValueCollectionSaverContextInterface
    {
        return new EavAttributeValueCollectionSaverContext(
            $this->idGeneratorStrategyFactory->createIdGeneratorStrategy(),
        );
    }
}