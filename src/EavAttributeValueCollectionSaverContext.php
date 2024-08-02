<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class EavAttributeValueCollectionSaverContext implements EavAttributeValueCollectionSaverContextInterface
{
    private CollectionSaverInterface $strategy;

    public function setStrategy(CollectionSaverInterface $strategy): EavAttributeValueCollectionSaverContext
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function processSaveEavAttributeValue(ModelInCollectionInterface $entity, string $entityType, ModelInCollectionInterface $attribute, mixed $value): void
    {
        /** @var \StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractEavAttributeValueModel|class-string $modelClass */
        $modelClass = $this->strategy->getModelInstance();
        $eavAttributeValueModel = new $modelClass(
            $entity,
            $entityType,
            $attribute,
            $value,
        );

        $this->strategy->saveModel($eavAttributeValueModel);
    }
}
