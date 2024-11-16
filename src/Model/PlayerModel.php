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
        private ?int    $elo = null,
        private ?int $fideId = null,
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
            'fideId' => $this->fideId,
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'elo' => $this->elo,
            'fideId' => $this->fideId,
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

    public static function getInstance(...$data): static
    {
        if (isset($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
        }

        $playerModel = parent::getInstance(...$data);

        if (isset($id)) {
            $playerModel->setId($id);
        }

        return $playerModel;
    }

    public function setElo(?int $elo): PlayerModel
    {
        $this->elo = $elo;

        return $this;
    }

    public function setFideId(?int $fideId): PlayerModel
    {
        $this->fideId = $fideId;

        return $this;
    }
}
