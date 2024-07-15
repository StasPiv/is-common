<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

interface ModelAwareInterface extends StringInterface
{
    /**
     * @return class-string
     */
    public function getModelInstance(): string;
}