<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Database;
use MongoDB\InsertOneResult;
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

    public function saveModel(string $collection, ModelInCollectionInterface $model, bool $update = false): bool
    {
        $data = $model->getDataForSave();

        if (isset($data['id'])) {
            $data['_id'] = $data['id'];

            unset($data['id']);
        }

        if ($update && !isset($data['_id'])) {
            return false;
        }

        try {
            $result = $update ?
                $this->database->selectCollection($collection)->updateOne(['_id' => $data['_id']], ['$set' => $data]) :
                $this->database->selectCollection($collection)->insertOne($data);
        } catch (\Throwable $exception) {
            $this->eventManager->notify(
                ProcessEventTypeEnum::ModelSaveFailed,
                new DataAwareProcessDataModel(['exception' => $exception->getMessage(),])
            );

            return false;
        }

        return $result instanceof InsertOneResult ? $result->getInsertedCount() > 0 : $result->getUpsertedCount() > 0;
    }
}