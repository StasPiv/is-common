<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverInterface;

class EavAttributeValueCollectionSaverContext implements EavAttributeValueCollectionSaverContextInterface
{
    private EavAttributeValueCollectionSaverInterface $strategy;

    public function setStrategy(EavAttributeValueCollectionSaverInterface $strategy): EavAttributeValueCollectionSaverContext
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function processSaveEavAttributeValue(string $entityId, string $attributeId, mixed $value): void
    {
        $this->strategy->saveEavAttributeValue($entityId, $attributeId, $value);
    }
}
