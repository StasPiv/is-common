<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class ScoreMessageModel extends AbstractMessageModel  implements MessageModelInterface, ProcessDataInterface
{
    public function __construct(
        private readonly string $fen,
        private readonly ?int $score,
        private readonly string $moveId,
    ) {
    }

    public function getDataForSerialize(): array
    {
        return [
            'fen' => $this->fen,
            'score' => $this->score,
            'moveId' => $this->moveId,
        ];
    }

    public function getFen(): string
    {
        return $this->fen;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function getMoveId(): string
    {
        return $this->moveId;
    }
}