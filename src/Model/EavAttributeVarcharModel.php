<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class EavAttributeVarcharModel implements ModelInCollectionInterface
{
    use StringSerializableTrait;

    public function __construct(
        private readonly string $id,
        private readonly string $entityId,
        private readonly string $attributeId,
        private readonly string $value,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'entityId' => $this->entityId,
            'attributeId' => $this->attributeId,
            'value' => $this->value,
        ];
    }
}