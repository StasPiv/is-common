<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface PgnHashGeneratorInterface
{
    public function generatePgnHash(string $pgn): string;
}
