<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveScoreUpdaterInterface;

interface MoveScoreUpdaterFactoryInterface
{
    public function createMoveScoreUpdater(): MoveScoreUpdaterInterface;
}
