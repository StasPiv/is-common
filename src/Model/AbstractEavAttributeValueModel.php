<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\EavAttributeValueException;

abstract class AbstractEavAttributeValueModel extends AbstractMessageModel implements ModelInCollectionInterface
{
    protected string $id;
    protected string $entityId;
    protected string $attributeId;

    final public function __construct(
        protected readonly ModelInCollectionInterface $entity,
        protected readonly string $entityType,
        protected readonly EavAttributeModel $attribute,
        protected mixed $value,
    ) {
        if (!$this->checkValueType($this->value)) {
            throw new EavAttributeValueException(
                sprintf('Type of value %s for class %s is incorrect', $this->value, static::class),
            );
        }
    }

    abstract protected function checkValueType(mixed $value): bool;

    public function getDataForSerialize(): array
    {
        return [
            'entity' => $this->entity->getDataForSerialize(),
            'entityType' => $this->entityType,
            'attribute' => $this->attribute->getDataForSerialize(),
            'value' => $this->value,
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'entityId' => $this->entity->getId(),
            'entityType' => $this->entityType,
            'attributeId' => $this->attribute->getId(),
            'value' => $this->value,
        ];
    }

    public static function getInstance(...$data): static
    {
        // todo: change when deal with different entities
        $data['entity'] = GameMessageModel::getInstance(...$data['entity']);
        $data['attribute'] = EavAttributeModel::getInstance(...$data['attribute']);

        return parent::getInstance(...$data);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setEntityId(string $entityId): void
    {
        $this->entityId = $entityId;
    }

    public function getEntityId(): string
    {
        return $this->entityId;
    }

    public function getEntity(): ModelInCollectionInterface
    {
        return $this->entity;
    }

    public function setAttributeId(string $attributeId): void
    {
        $this->attributeId = $attributeId;
    }

    public function getAttribute(): EavAttributeModel
    {
        return $this->attribute;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }
}