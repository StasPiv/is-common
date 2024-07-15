<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\PgnHashGeneratorInterface;

class Sha1PgnHashGenerator implements PgnHashGeneratorInterface
{
    public function generatePgnHash(string $pgn): string
    {
        return sha1($pgn);
    }
}
