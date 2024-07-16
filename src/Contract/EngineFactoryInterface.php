<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StasPiv\ChessBestMove\Model\EngineConfiguration;
use StasPiv\ChessBestMove\Service\ChessBestMove;

interface EngineFactoryInterface
{
    public function createChessBestMove(): ChessBestMove;

    public function createEngineConfiguration(): EngineConfiguration;
}