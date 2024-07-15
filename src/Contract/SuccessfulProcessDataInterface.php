<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface SuccessfulProcessDataInterface extends ProcessDataInterface, StringInterface
{
    public function getModelInCollection(): ModelInCollectionInterface;

    public function getInfoMessage(): string;
}