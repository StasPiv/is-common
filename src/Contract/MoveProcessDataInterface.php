<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Model\PlayerModel;

interface MoveProcessDataInterface
{
    public function getMoveNumber(): int;

    public function getSide(): string;

    public function getPlayer(): PlayerModel;

    public function getOpponent(): PlayerModel;

    public function getMoveNotation(): string;

    public function getFenBefore(): string;

    public function getFenAfter(): string;

    public function getGameId(): string;
}