<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\EavAttributeValueCollectionSaverContext;

interface EavAttributeValueCollectionSaverContextInterface
{
    public function setStrategy(CollectionSaverInterface $strategy): EavAttributeValueCollectionSaverContext;

    public function processSaveEavAttributeValue(ModelInCollectionInterface $entity, string $entityType, ModelInCollectionInterface $attribute, mixed $value): void;
}