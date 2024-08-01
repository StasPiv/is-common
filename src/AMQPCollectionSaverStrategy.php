<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\ModelAndCollectionMessageModel;

class AMQPCollectionSaverStrategy implements Contract\CollectionSaverStrategyInterface
{
    public function __construct(
        private readonly PublisherInterface $publisher,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function saveModel(string $collection, ModelInCollectionInterface $model): bool
    {
        $modelForPublish = new ModelAndCollectionMessageModel($collection, $model);
        $this->publisher->publish($modelForPublish);
        $this->eventManager->notify(ProcessEventTypeEnum::ModelPublished, $modelForPublish);

        return true;
    }
}