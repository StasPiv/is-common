<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class FenAwareMessageModel implements ProcessDataInterface, MessageModelInterface
{
    public function __construct(
        private readonly string $fen,
    ) {
    }

    public function __toString(): string
    {
        return serialize($this);
    }

    public function getFen(): string
    {
        return $this->fen;
    }
}