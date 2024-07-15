<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface SavableModelInterface
{
    public function getData(): array;
}