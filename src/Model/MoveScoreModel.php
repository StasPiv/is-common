<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MoveScoreModel implements ModelInCollectionInterface
{
    use StringSerializableTrait;

    public function __construct(
        private readonly string $moveId,
        private readonly string $scoreBefore,
        private readonly string $scoreAfter,
        private ?string $diff,
    ) {
    }

    public function getId(): string
    {
        return $this->moveId;
    }

    public function getData(): array
    {
        return [
            'moveId' => $this->moveId,
            'scoreBefore' => $this->scoreBefore,
            'scoreAfter' => $this->scoreAfter,
            'diff' => $this->diff,
        ];
    }

    public function getMoveId(): string
    {
        return $this->moveId;
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
}
