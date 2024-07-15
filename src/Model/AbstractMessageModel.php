<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ArrayInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;

abstract class AbstractMessageModel implements MessageModelInterface, ArrayInterface
{
    abstract public function toArray(): array;

    abstract public static function getProperties(): array;

    public function __toString(): string
    {
        return serialize($this);
    }
}
