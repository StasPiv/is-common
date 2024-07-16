<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface SavableModelInterface extends ProcessDataInterface
{
    public function getData(): array;
}