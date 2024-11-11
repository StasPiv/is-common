<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class EventMessageModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    private string $id;

    public function __construct(
        private readonly string $name,
        private readonly string $uploadId,
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getUploadId(): string
    {
        return $this->uploadId;
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uploadId' => $this->uploadId,
        ];
    }

    public function getDataForSerialize(): array
    {
        return $this->getDataForSave();
    }
}
