<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

class PlayerModel extends AbstractMessageModel implements StringInterface, ModelInCollectionInterface
{
    use StringJsonEncodableTrait;
    use IdAwareTrait;

    public function __construct(
        private readonly ?string $name = null,
        private readonly ?int    $elo = null,
        private readonly ?int $fideId = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->getDataForSerialize();
    }

    public function getDataForSerialize(): array
    {
        return [
            'name' => $this->name,
            'elo' => $this->elo,
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getElo(): ?int
    {
        return $this->elo;
    }

    public function getFideId(): ?int
    {
        return $this->fideId;
    }
}
