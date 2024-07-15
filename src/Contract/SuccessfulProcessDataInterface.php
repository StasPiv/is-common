<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\SuccessfulProcessData;

interface SuccessfulProcessDataInterface extends ProcessDataInterface
{
    public function getModelInCollection(): ModelInCollectionInterface;

    public function getInfoMessage(): string;
}