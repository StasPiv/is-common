<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface IdGeneratorStrategyInterface
{
    public function generateId(): string;
}
