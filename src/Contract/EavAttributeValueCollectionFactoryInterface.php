<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface EavAttributeValueCollectionFactoryInterface extends CollectionFactoryInterface
{
    public function createCollectionSaver(): EavAttributeValueCollectionSaverInterface;
}