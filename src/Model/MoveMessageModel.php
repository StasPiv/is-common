<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class MoveMessageModel extends AbstractMessageModel implements MessageModelInterface, ProcessDataInterface
{
    public function __construct(
        private readonly GameMessageModel $game,
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

    public static function getInstance(...$data): static
    {
        $data['game'] = GameMessageModel::getInstance(...$data['game']);
        $data['player'] = PlayerModel::getInstance(...$data['player']);
        $data['opponent'] = PlayerModel::getInstance(...$data['opponent']);

        return parent::getInstance(...$data);
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
}