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
        private readonly ?string $name = null,
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
        ];
    }

    public function getDataForSerialize(): array
    {
        return $this->getDataForSave();
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getUploadedAt(): string
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
}