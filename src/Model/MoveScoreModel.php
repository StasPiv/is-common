<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MoveScoreModel extends AbstractMessageModel implements ModelInCollectionInterface
{
    use StringJsonEncodableTrait;

    private string $id;

    public function __construct(
        private readonly MoveMessageModel $move,
        private ?string                   $scoreBefore,
        private ?string                   $scoreAfter,
        private ?string                   $diff,
        private ?string                   $accuracy,
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

    public function getDataForSerialize(): array
    {
        return [
            'move' => $this->move->getDataForSerialize(),
            'scoreBefore' => $this->scoreBefore,
            'scoreAfter' => $this->scoreAfter,
            'diff' => $this->diff,
            'accuracy' => $this->accuracy,
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->move->getId(),
            'scoreBefore' => $this->scoreBefore,
            'scoreAfter' => $this->scoreAfter,
            'accuracy' => $this->accuracy,
        ];
    }

    public static function getInstance(...$data): static
    {
        $data['move'] = MoveMessageModel::getInstance(...$data['move']);

        return parent::getInstance(...$data);
    }

    public function getScoreBefore(): ?string
    {
        return $this->scoreBefore;
    }

    public function getScoreAfter(): ?string
    {
        return $this->scoreAfter;
    }

    public function getDiff(): ?int
    {
        return $this->diff !== null ? (int) $this->diff : null;
    }

    public function setDiff(?string $diff): MoveScoreModel
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccuracy(): ?string
    {
        return $this->accuracy;
    }

    /**
     * @param string|null $accuracy
     *
     * @return MoveScoreModel
     */
    public function setAccuracy(?string $accuracy): MoveScoreModel
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function setScoreBefore(string $scoreBefore): MoveScoreModel
    {
        $this->scoreBefore = $scoreBefore;

        return $this;
    }

    public function setScoreAfter(string $scoreAfter): MoveScoreModel
    {
        $this->scoreAfter = $scoreAfter;

        return $this;
    }

    public function getMove(): MoveMessageModel
    {
        return $this->move;
    }
}
