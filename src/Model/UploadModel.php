<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class UploadModel implements ModelInCollectionInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private string $id,
        private readonly string $user,
        private readonly \DateTime $uploadedAt,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getDataForSave(): array
    {
        return [
            $this->id,
            $this->user,
            $this->uploadedAt,
        ];
    }

    public function getDataForSerialize(): array
    {
        return $this->getDataForSave();
    }
}