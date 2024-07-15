<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;

interface PgnAwareModelInterface extends MessageModelInterface
{
    public function getPgn(): string;
}