<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface FailedProcessDataInterface extends ProcessDataInterface
{
    public function getErrorMessage(): string;
}