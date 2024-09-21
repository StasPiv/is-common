<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Database;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MongoStorageSaver implements Contract\StorageSaverInterface
{
    public function __construct(
        private readonly Database $database,
    ) {
    }

    public function saveModel(string $collection, ModelInCollectionInterface $model): bool
    {
        $data = $model->getDataForSave();

        if (!isset($data['_id'])) {
            $data['_id'] = $model->getId();
        }

        if (isset($data['id'])) {
            unset($data['id']);
        }

        $result = $this->database->selectCollection($collection)->insertOne($data);

        return $result->getInsertedCount() > 0;
    }
}