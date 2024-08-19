<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

class DiffModel
{
    private string $fen;
    private string $gameMove;
    private string $bestMove;
    private int $bestScore;
    private int $gameScore;

    public function __construct(string $fen, string $gameMove, string $bestMove, int $bestScore, int $gameScore)
    {
        $this->bestScore = $bestScore;
        $this->gameScore = $gameScore;
        $this->fen = $fen;
        $this->gameMove = $gameMove;
        $this->bestMove = $bestMove;
    }

    public function getFen(): string
    {
        return $this->fen;
    }

    public function getGameMove(): string
    {
        return $this->gameMove;
    }

    public function getBestScore(): int
    {
        return $this->bestScore;
    }

    public function getGameScore(): int
    {
        return $this->gameScore;
    }

    public function getBestMove(): string
    {
        return $this->bestMove;
    }
}