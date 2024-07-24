<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface EavAttributeValueCollectionSaverInterface
{
    public function saveEavAttributeValue(string $entityId, string $attributeId, mixed $value): void;
}