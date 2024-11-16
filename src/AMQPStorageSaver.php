<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\ModelAndCollectionMessageModel;

class AMQPStorageSaver implements StorageSaverInterface
{
    public function __construct(
        private readonly PublisherInterface $publisher,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function saveModel(string $collection, ModelInCollectionInterface $model, bool $update = false): bool
    {
        $modelForPublish = new ModelAndCollectionMessageModel($collection, $model);
        $this->publisher->publish($modelForPublish);
        $this->eventManager->notify(ProcessEventTypeEnum::ModelPublished, $modelForPublish);

        return true;
    }
}