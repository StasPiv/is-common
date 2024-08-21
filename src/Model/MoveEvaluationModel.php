<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

class MoveEvaluationModel extends AbstractMessageModel
{
    use StringJsonEncodableTrait;

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

    public function getDataForSerialize(): array
    {
        return [
            'fen' => $this->fen,
            'gameMove' => $this->gameMove,
            'bestMove' => $this->bestMove,
            'gameScore' => $this->gameScore,
            'bestScore' => $this->bestScore,
        ];
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