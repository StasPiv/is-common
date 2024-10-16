<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Database;
use MongoDB\Model\BSONDocument;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

abstract class AbstractMongoCollectionFinder implements Contract\CollectionFinderInterface
{
    public function __construct(
        private readonly Database $database,
    ) {
    }

    public function findUnique(ModelInCollectionInterface $model): ?ModelInCollectionInterface
    {
        return $this->findOneBy($this->getUniqueCriteria($model));
    }

    /**
     * @inheritDoc
     */
    public function find(string $id): ?ModelInCollectionInterface
    {
        return $this->findOneBy(['_id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function findAll(array $criteria): array
    {
        /** @var array<\MongoDB\Model\BSONDocument> $objects */
        $objects = $this->database->selectCollection($this->getCollection())->find($criteria);

        $models = [];

        foreach ($objects as $object) {
            $models[] = $this->makeModel($object);
        }

        return $models;
    }

    public function findOneBy(array $criteria): ?ModelInCollectionInterface
    {
        /** @var \MongoDB\Model\BSONDocument $object */
        $object = $this->database->selectCollection($this->getCollection())->findOne($criteria);

        if (!$object) {
            return null;
        }

        return $this->makeModel($object);
    }

    abstract protected function getUniqueCriteria(ModelInCollectionInterface|GameMessageModel $model): array;

    protected function makeModel(BSONDocument $object): ModelInCollectionInterface
    {
        $data = $object->getArrayCopy();
        $data['id'] = $data['_id'];
        unset($data['_id']);

        $modelClassInstance = $this->getModelInstanceClass();

        return $modelClassInstance::getInstance(...$data);
    }
}