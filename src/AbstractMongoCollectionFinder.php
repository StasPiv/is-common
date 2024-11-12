<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Database;
use MongoDB\Model\BSONDocument;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\BSONDocumentModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

abstract class AbstractMongoCollectionFinder implements Contract\CollectionFinderInterface
{
    public function __construct(
        private readonly Database $database,
        private readonly bool $simpleModels = false,
    ) {
    }

    public function findUnique(ModelInCollectionInterface $model, array $options = []): ?ModelInCollectionInterface
    {
        return $this->findOneBy($this->getUniqueCriteria($model), $options);
    }

    /**
     * @param array $options *
     *
     * @inheritDoc
     */
    public function find(string $id, array $options = []): ?ModelInCollectionInterface
    {
        $criteria = array_merge(['_id' => $id], $this->getDefaultCriteria());

        return $this->findOneBy($criteria, $options);
    }

    /**
     * @param array $options *
     *
     * @inheritDoc
     */
    public function findAll(array $criteria, array $options = []): array
    {
        $criteria = array_merge($criteria, $this->getDefaultCriteria());

        /** @var array<\MongoDB\Model\BSONDocument> $objects */
        $objects = $this->database->selectCollection($this->getCollection())->find($criteria, $options);

        $models = [];

        foreach ($objects as $object) {
            $models[] = $this->makeModel($object);
        }

        return $models;
    }

    public function findOneBy(array $criteria, array $options = []): ?ModelInCollectionInterface
    {
        $criteria = array_merge($criteria, $this->getDefaultCriteria());

        /** @var \MongoDB\Model\BSONDocument $object */
        $object = $this->database->selectCollection($this->getCollection())->findOne($criteria, $options);

        if (!$object) {
            return null;
        }

        return $this->makeModel($object);
    }

    abstract protected function getUniqueCriteria(ModelInCollectionInterface|GameMessageModel $model): array;

    protected function makeModel(BSONDocument $object): ModelInCollectionInterface
    {
        if ($this->simpleModels) {
            return new BSONDocumentModel($object);
        }

        $data = $object->getArrayCopy();

        if (isset($data['_id'])) {
            $data['id'] = $data['_id'];
            unset($data['_id']);
        } else {
            $data['id'] = '';
        }

        $modelClassInstance = $this->getModelInstanceClass();

        return $modelClassInstance::getInstance(...$data);
    }

    protected function getDefaultCriteria(): array
    {
        return [];
    }
}