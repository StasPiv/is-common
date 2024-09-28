<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class UploadModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private string $id,
        private readonly string $user,
        private readonly string $uploadedAt,
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