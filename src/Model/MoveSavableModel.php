<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MoveSavableModel implements ModelInCollectionInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $gameId,
        private readonly int $moveNumber,
        private readonly string $side,
        private readonly string $move,
        private readonly string $fenBefore,
        private readonly string $fenAfter,
        private readonly string $player,
        private readonly string $opponent,
        private readonly int $playerElo,
        private readonly int $opponentElo,
    ) {
    }

    public function getCollection(): string
    {
        return 'moves';
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'game_id' => $this->gameId,
            'move_number' => $this->moveNumber,
            'side' => $this->side,
            'move' => $this->move,
            'fen_before' => $this->fenBefore,
            'fen_after' => $this->fenAfter,
            'player' => $this->player,
            'opponent' => $this->opponent,
            'player_elo' => $this->playerElo,
            'opponent_elo' => $this->opponentElo,
        ];
    }

    public function __toString(): string
    {
        return serialize($this);
    }

    public function getFenBefore(): string
    {
        return $this->fenBefore;
    }

    public function getFenAfter(): string
    {
        return $this->fenAfter;
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function getMoveNumber(): int
    {
        return $this->moveNumber;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function getMove(): string
    {
        return $this->move;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }

    public function getOpponent(): string
    {
        return $this->opponent;
    }

    public function getPlayerElo(): int
    {
        return $this->playerElo;
    }

    public function getOpponentElo(): int
    {
        return $this->opponentElo;
    }
}