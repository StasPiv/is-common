<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class EavAttributeModel implements ModelInCollectionInterface
{
    use StringSerializableTrait;

    public function __construct(
        private readonly string $id,
        private readonly int $type,
        private readonly string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
        ];
    }
}