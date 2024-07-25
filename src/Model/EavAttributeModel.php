<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class EavAttributeModel implements ModelInCollectionInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private readonly string $id,
        private readonly string $type,
        private readonly string $name,
        private readonly string $table,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'table' => $this->table,
        ];
    }
}