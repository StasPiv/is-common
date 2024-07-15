<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;

interface PgnParseMessageModelInterface extends MessageModelInterface
{
    public function getId(): string;

    public function getPgn(): string;
}