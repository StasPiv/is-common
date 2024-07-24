<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class DataAwareProcessDataModel implements ProcessDataInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private readonly array $data,
    ) {
    }

    protected function getData(): array
    {
        return $this->data;
    }
}