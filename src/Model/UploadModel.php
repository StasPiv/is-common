<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class UploadModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private string $id,
        private readonly ?string $user = null,
        private readonly ?string $uploadedAt = null,
        private readonly ?string $name = null,
        private readonly ?string $description = null,
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
            'id' => $this->id,
            'user' => $this->user,
            'uploadedAt' => $this->uploadedAt,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function getDataForSerialize(): array
    {
        return $this->getDataForSave();
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function getUploadedAt(): ?string
    {
        return $this->uploadedAt;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}