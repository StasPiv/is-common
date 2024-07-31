<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverStrategyFactoryInterface;

abstract class AbstractCollectionSaverFactory implements CollectionSaverFactoryInterface
{
    public function __construct(
        private readonly CollectionSaverStrategyFactoryInterface $collectionSaverStrategyFactory,
        private readonly CollectionSaverContextFactoryInterface $collectionSaverContextFactory,
    ) {
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        $saverClassName = $this->getCollectionSaverClassName();

        return new $saverClassName(
            $this->collectionSaverContextFactory->createCollectionSaverContext(),
            $this->collectionSaverStrategyFactory->createSaverStrategy(),
        );
    }

    /**
     * @return class-string
     */
    abstract protected function getCollectionSaverClassName(): string;
}