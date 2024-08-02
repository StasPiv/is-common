<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MoveSavableMessageModel extends AbstractMessageModel implements ModelInCollectionInterface
{
    private string $id;
    private string $gameId;

    public function __construct(
        private readonly GameMessageModel $gameModel,
        private readonly string $moveNumber,
        private readonly string $side,
        private readonly string $move,
        private readonly string $fenBefore,
        private readonly string $fenAfter,
        private readonly string $player,
        private readonly string $opponent,
        private readonly string $playerElo,
        private readonly string $opponentElo,
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

    public function setGameId(string $gameId): void
    {
        $this->gameId = $gameId;
    }

    public function getGameModel(): GameMessageModel
    {
        return $this->gameModel;
    }

    public function getData(): array
    {
        return [
            'game' => $this->gameModel->getData(),
            'moveNumber' => $this->moveNumber,
            'side' => $this->side,
            'move' => $this->move,
            'fenBefore' => $this->fenBefore,
            'fenAfter' => $this->fenAfter,
            'player' => $this->player,
            'opponent' => $this->opponent,
            'playerElo' => $this->playerElo,
            'opponentElo' => $this->opponentElo,
        ];
    }

    public static function getInstance(...$data): static
    {
        $data['game'] = GameMessageModel::getInstance(...$data['game']);

        return parent::getInstance($data);
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
        return (int) $this->moveNumber;
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
        return (int) $this->playerElo;
    }

    public function getOpponentElo(): int
    {
        return (int) $this->opponentElo;
    }
}