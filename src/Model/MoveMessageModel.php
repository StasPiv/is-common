<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class MoveMessageModel extends AbstractMessageModel implements MessageModelInterface, ProcessDataInterface
{
    private string $gameId;

    public function __construct(
        private readonly int $moveNumber,
        private readonly string $side,
        private readonly PlayerModel $player,
        private readonly PlayerModel $opponent,
        private readonly string $moveNotation,
        private readonly string $fenBefore,
        private readonly string $fenAfter,
    ) {
    }

    public function toArray(): array
    {
        return [
            'gameId' => $this->gameId,
            'moveNumber' => $this->moveNumber,
            'side' => $this->side,
            'player' => $this->player,
            'opponent' => $this->opponent,
            'moveNotation' => $this->moveNotation,
            'fenBefore' => $this->fenBefore,
            'fenAfter' => $this->fenAfter,
        ];
    }

    public static function getProperties(): array
    {
        return ['moveNumber', 'gameId', 'side', 'player', 'opponent', 'moveNotation', 'fenBefore', 'fenAfter'];
    }

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function setGameId(string $gameId): MoveMessageModel
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getMoveNumber(): int
    {
        return $this->moveNumber;
    }

    public function getSide(): string
    {
        return $this->side;
    }

    public function getPlayer(): PlayerModel
    {
        return $this->player;
    }

    public function getOpponent(): PlayerModel
    {
        return $this->opponent;
    }

    public function getMoveNotation(): string
    {
        return $this->moveNotation;
    }

    public function getFenBefore(): string
    {
        return $this->fenBefore;
    }

    public function getFenAfter(): string
    {
        return $this->fenAfter;
    }
}