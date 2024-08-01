<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface EavAttributeValueCollectionSaverContextFactoryInterface
{
    public function createContext(): EavAttributeValueCollectionSaverContextInterface;
}