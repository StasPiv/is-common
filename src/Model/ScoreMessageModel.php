<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class ScoreMessageModel extends AbstractMessageModel  implements MessageModelInterface, ProcessDataInterface
{
    public function __construct(
        private readonly string $fen,
        private readonly int $score,
    ) {
    }

    public function toArray(): array
    {
        return [
            'fen' => $this->fen,
            'score' => $this->score,
        ];
    }

    public static function getProperties(): array
    {
        return ['fen', 'score'];
    }

    public function getFen(): string
    {
        return $this->fen;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}