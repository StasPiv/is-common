<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;

class EavAttributeValueCollectionSaverContext implements EavAttributeValueCollectionSaverContextInterface
{
    private CollectionSaverInterface $strategy;

    public function __construct(
        private readonly IdGeneratorStrategyInterface $idGeneratorStrategy,
    ) {
    }

    public function setStrategy(CollectionSaverInterface $strategy): EavAttributeValueCollectionSaverContext
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function processSaveEavAttributeValue(string $entityId, string $attributeId, mixed $value): void
    {
        $modelClass = $this->strategy->getModelInstance();
        $eavAttributeValueModel = new $modelClass(
            $this->idGeneratorStrategy->generateId(),
            $entityId,
            $attributeId,
            $value,
        );

        $this->strategy->saveModel($eavAttributeValueModel);
    }
}
