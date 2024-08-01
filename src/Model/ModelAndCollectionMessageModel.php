<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\MoveAndCollectionMessageException;

class ModelAndCollectionMessageModel extends AbstractMessageModel implements ProcessDataInterface
{
    use StringJsonEncodableTrait;

    private static array $map = [
        'games' => GameMessageModel::class,
        'eav_attributes' => EavAttributeModel::class,
        'eav_attribute_int' => EavAttributeIntModel::class,
        'eav_attribute_varchar' => EavAttributeVarcharModel::class,
        'moves' => MoveSavableMessageModel::class,
        'move_scores' => MoveScoreModel::class,
    ];

    public function __construct(
        private readonly string $collection,
        private readonly ModelInCollectionInterface $model,
    ) {
    }

    public static function getInstance(...$data): static
    {
        $collectionClassInstance = self::getClassInstance($data['collection']);
        $data['model'] = $collectionClassInstance::getInstance(...$data['model']);

        return parent::getInstance(...$data);
    }

    /**
     * @return \StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractMessageModel|class-string
     */
    private static function getClassInstance(string $collection): string
    {
        if (!isset(self::$map[$collection])) {
            throw new MoveAndCollectionMessageException('Unknown collection ' . $collection);
        }

        return self::$map[$collection];
    }

    protected function getData(): array
    {
        return [
            'collection' => $this->collection,
            'model' => $this->model->getData(),
        ];
    }

    /**
     * @return string
     */
    public function getCollection(): string
    {
        return $this->collection;
    }

    /**
     * @return \StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface
     */
    public function getModel(): ModelInCollectionInterface
    {
        return $this->model;
    }
}