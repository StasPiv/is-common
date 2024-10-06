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
        private ?int                   $scoreBefore,
        private ?int                   $scoreAfter,
        private ?int                   $diff,
        private ?float                   $accuracy,
        private ?string                   $bestMove,
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

    /**
     * @param string|null $bestMove
     *
     * @return MoveScoreModel
     */
    public function setBestMove(?string $bestMove): MoveScoreModel
    {
        $this->bestMove = $bestMove;

        return $this;
    }

    public function getDataForSerialize(): array
    {
        return [
            'move' => $this->move->getDataForSerialize(),
            'scoreBefore' => $this->scoreBefore,
            'scoreAfter' => $this->scoreAfter,
            'diff' => $this->diff,
            'accuracy' => $this->accuracy,
            'bestMove' => $this->bestMove,
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->move->getId(),
            'scoreBefore' => $this->scoreBefore,
            'scoreAfter' => $this->scoreAfter,
            'diff' => $this->diff,
            'accuracy' => $this->accuracy,
            'bestMove' => $this->bestMove,
        ];
    }

    public static function getInstance(...$data): static
    {
        $data['move'] = MoveMessageModel::getInstance(...$data['move']);

        return parent::getInstance(...$data);
    }

    public function getScoreBefore(): ?int
    {
        return $this->scoreBefore;
    }

    public function getScoreAfter(): ?int
    {
        return $this->scoreAfter;
    }

    public function getDiff(): ?int
    {
        return $this->diff;
    }

    public function setDiff(?int $diff): MoveScoreModel
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAccuracy(): ?float
    {
        return $this->accuracy;
    }

    /**
     * @param float|null $accuracy
     *
     * @return MoveScoreModel
     */
    public function setAccuracy(?float $accuracy): MoveScoreModel
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function setScoreBefore(?int $scoreBefore): MoveScoreModel
    {
        $this->scoreBefore = $scoreBefore;

        return $this;
    }

    public function setScoreAfter(?int $scoreAfter): MoveScoreModel
    {
        $this->scoreAfter = $scoreAfter;

        return $this;
    }

    public function getMove(): MoveMessageModel
    {
        return $this->move;
    }
}
