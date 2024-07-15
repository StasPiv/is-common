<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;

interface MoveProcessDataInterface extends StringInterface
{
    public function getMoveMessageModel(): MoveMessageModel;
}