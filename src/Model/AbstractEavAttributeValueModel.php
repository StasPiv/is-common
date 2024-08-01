<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\EavAttributeValueException;

abstract class AbstractEavAttributeValueModel extends AbstractMessageModel implements ModelInCollectionInterface
{
    final public function __construct(
        protected string $id,
        protected string $entityId,
        protected string $attributeId,
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
}