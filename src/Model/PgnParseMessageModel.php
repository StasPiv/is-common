<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Model\PgnParseMessageModelInterface;

class PgnParseMessageModel extends AbstractMessageModel implements MessageModelInterface, PgnParseMessageModelInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $pgn,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPgn(): string
    {
        return $this->pgn;
    }
}
