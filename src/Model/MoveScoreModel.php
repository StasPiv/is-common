<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MoveScoreModel implements ModelInCollectionInterface
{
    use StringSerializableTrait;

    public function __construct(
        private readonly string $id,
        private ?string         $scoreBefore,
        private ?string         $scoreAfter,
        private ?string         $diff,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'scoreBefore' => $this->scoreBefore,
            'scoreAfter' => $this->scoreAfter,
            'diff' => $this->diff,
        ];
    }

    public function getScoreBefore(): int
    {
        return (int) $this->scoreBefore;
    }

    public function getScoreAfter(): int
    {
        return (int) $this->scoreAfter;
    }

    public function getDiff(): int
    {
        return (int) $this->diff;
    }

    public function setDiff(string $diff): MoveScoreModel
    {
        $this->diff = $diff;

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
}
