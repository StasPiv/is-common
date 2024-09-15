<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

trait StringJsonEncodableTrait
{
    public function __toString(): string
    {
        $str = json_encode($this->getDataForSerialize());

        if (!is_string($str)) {
            return '';
        }

        return $str;
    }

    abstract public function getDataForSerialize(): array;
}