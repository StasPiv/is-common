<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StasPiv\ChessBestMove\Service\ChessBestMove;

interface ChessBestMoveFactoryInterface
{
    public function createChessBestMove(): ChessBestMove;
}