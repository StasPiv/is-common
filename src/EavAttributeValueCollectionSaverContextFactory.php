<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextInterface;

class EavAttributeValueCollectionSaverContextFactory implements EavAttributeValueCollectionSaverContextFactoryInterface
{
    public function createContext(): EavAttributeValueCollectionSaverContextInterface
    {
        return new EavAttributeValueCollectionSaverContext();
    }
}