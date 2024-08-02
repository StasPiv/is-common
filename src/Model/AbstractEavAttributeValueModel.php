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

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'entityId' => $this->entityId,
            'attributeId' => $this->attributeId,
            'value' => $this->value,
        ];
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