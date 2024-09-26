<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EavAttributeValueCollectionSaverContextInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\EavAttributeValueException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;

class EavAttributeValueCollectionSaverContext implements EavAttributeValueCollectionSaverContextInterface
{
    private CollectionSaverInterface $strategy;

    public function __construct(
        private readonly EventManagerInterface $eventManager,
        private readonly IdGeneratorStrategyInterface $idGeneratorStrategy,
    ) {
    }

    public function setStrategy(CollectionSaverInterface $strategy): EavAttributeValueCollectionSaverContext
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function processSaveEavAttributeValue(ModelInCollectionInterface $entity, string $entityType, ModelInCollectionInterface $attribute, mixed $value): void
    {
        /** @var \StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractEavAttributeValueModel|class-string $modelClass */
        $modelClass = $this->strategy->getModelInstanceClass();

        try {
            $eavAttributeValueModel = new $modelClass(
                $entity,
                $entityType,
                $attribute,
                $value,
            );

            $eavAttributeValueModel->setId($this->idGeneratorStrategy->generateId());
        } catch (EavAttributeValueException $exception) {
            $this->eventManager->notify(
                ProcessEventTypeEnum::ModelSaveFailed,
                new DataAwareProcessDataModel(
                    [
                        'exception' => $exception->getMessage(),
                    ],
                ),
            );

            return;
        }

        $this->strategy->saveModel($eavAttributeValueModel);
    }
}
