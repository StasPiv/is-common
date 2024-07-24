<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\EavAttributeValueCollectionSaverContext;

interface EavAttributeValueCollectionSaverContextInterface
{
    public function setStrategy(EavAttributeValueCollectionSaverInterface $strategy): EavAttributeValueCollectionSaverContext;

    public function processSaveEavAttributeValue(string $entityId, string $attributeId, mixed $value): void;
}