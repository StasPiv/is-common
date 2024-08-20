<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;

class EavAttributeValueCollectionSaverContextFactory implements EavAttributeValueCollectionSaverContextFactoryInterface
{
    public function __construct(
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createContext(): EavAttributeValueCollectionSaverContextInterface
    {
        return new EavAttributeValueCollectionSaverContext($this->eventManagerFactory->createEventManager());
    }
}