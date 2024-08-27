<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class MoveMessageModel extends AbstractMessageModel implements MessageModelInterface, ModelInCollectionInterface
{
    private string $id;

    public function __construct(
        private GameMessageModel $game,
        private readonly int $moveNumber,
        private readonly string $side,
        private readonly PlayerModel $player,
        private readonly PlayerModel $opponent,
        private readonly string $moveNotation,
        private readonly string $fenBefore,
        private readonly string $fenAfter,
    ) {
    }

    public function getDataForSerialize(): array
    {
        return [
            'id' => $this->id,
            'game' => $this->game->getDataForSerialize(),
            'moveNumber' => $this->moveNumber,
            'side' => $this->side,
            'player' => $this->player->toArray(),
            'opponent' => $this->opponent->toArray(),
            'moveNotation' => $this->moveNotation,
            'fenBefore' => $this->fenBefore,
            'fenAfter' => $this->fenAfter,
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->id,
            'gameId' => $this->game->getId(),
            'moveNumber' => $this->moveNumber,
            'side' => $this->side,
            'moveNotation' => $this->moveNotation,
            'fenBefore' => $this->fenBefore,
            'fenAfter' => $this->fenAfter,
            'player' => $this->player->getName(),
            'opponent' => $this->opponent->getName(),
            'playerElo' => $this->player->getElo(),
            'opponentElo' => $this->opponent->getElo(),
        ];
    }

    public static function getInstance(...$data): static
    {
        $data['game'] = GameMessageModel::getInstance(...$data['game']);
        $data['player'] = PlayerModel::getInstance(...$data['player']);
        $data['opponent'] = PlayerModel::getInstance(...$data['opponent']);
        $id = $data['id'];
        unset($data['id']);

        $moveMessageModel = parent::getInstance(...$data);
        $moveMessageModel->setId($id);

        return $moveMessageModel;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }

    public function getGameId(): string
    {
        return $this->game->getId();
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

    public function getGame(): GameMessageModel
    {
        return $this->game;
    }

    public function setGame(GameMessageModel $game): void
    {
        $this->game = $game;
    }
}