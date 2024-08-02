<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MoveScoreModel extends AbstractMessageModel implements ModelInCollectionInterface
{
    use StringJsonEncodableTrait;

    private string $id;

    public function __construct(
        private readonly MoveSavableMessageModel $moveModel,
        private ?string                          $scoreBefore,
        private ?string                          $scoreAfter,
        private ?string                          $diff,
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

    public function getData(): array
    {
        return [
            'move' => $this->moveModel->getData(),
            'scoreBefore' => $this->scoreBefore,
            'scoreAfter' => $this->scoreAfter,
            'diff' => $this->diff,
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

    /**
     * @return \StanislavPivovartsev\InterestingStatistics\Common\Model\MoveSavableMessageModel
     */
    public function getMoveModel(): MoveSavableMessageModel
    {
        return $this->moveModel;
    }
}
