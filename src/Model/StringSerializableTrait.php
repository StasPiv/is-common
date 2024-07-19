<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

trait StringSerializableTrait
{
    public function __toString(): string
    {
        return serialize($this);
    }
}