<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class StringAwareProcessDataModel implements ProcessDataInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private readonly string $name,
        private readonly string $value,
    ) {
    }

    protected function getData(): array
    {
        return [
            $this->name => $this->value,
        ];
    }
}