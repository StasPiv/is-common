<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Database;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;

class MongoStorageSaver implements Contract\StorageSaverInterface
{
    public function __construct(
        private readonly Database $database,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function saveModel(string $collection, ModelInCollectionInterface $model): bool
    {
        $data = $model->getDataForSave();

        if (isset($data['id'])) {
            $data['_id'] = $data['id'];

            unset($data['id']);
        }

        try {
            $result = $this->database->selectCollection($collection)->insertOne($data);
        } catch (\Throwable $exception) {
            $this->eventManager->notify(
                ProcessEventTypeEnum::ModelSaveFailed,
                new DataAwareProcessDataModel(['exception' => $exception->getMessage(),])
            );

            return false;
        }

        return $result->getInsertedCount() > 0;
    }
}