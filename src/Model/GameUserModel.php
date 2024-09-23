<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class GameUserModel implements ModelInCollectionInterface
{
    use StringJsonEncodableTrait;

    private string $id;

    public function __construct(
        private readonly string $gameId,
        private readonly string $user,
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
            'gameId' => $this->gameId,
            'user' => $this->user,
        ];
    }

    public function getDataForSerialize(): array
    {
        return $this->getDataForSave();
    }
}