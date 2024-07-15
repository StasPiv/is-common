<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\PlayerModel;

class MoveProcessData extends AbstractProcessData implements MoveProcessDataInterface
{
    final public function __construct(
        protected MessageInterface                  $message,
        private readonly string $gameId,
        private readonly string $moveNumber,
        private readonly string $side,
        private readonly PlayerModel $player,
        private readonly PlayerModel $opponent,
        private readonly string $moveNotation,
        private readonly string $fenBefore,
        private readonly string $fenAfter,
    ) {
        parent::__construct(ProcessEventTypeEnum::Success, $this->message);
    }

    public function getMoveNumber(): string
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

    public function getGameId(): string
    {
        return $this->gameId;
    }
}