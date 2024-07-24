<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface EavAttributeValueCollectionSaverFactoryInterface extends CollectionFactoryInterface
{
    public function createCollectionSaver(): EavAttributeValueCollectionSaverInterface;
}