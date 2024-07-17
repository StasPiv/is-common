<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

trait EventTypeTrait
{
    public function getName(): string
    {
        return $this->name;
    }
}