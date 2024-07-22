<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

trait StringJsonEncodableTrait
{
    public function __toString(): string
    {
        return json_encode($this->getData());
    }

    abstract protected function getData(): array;
}