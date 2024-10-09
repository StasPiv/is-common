<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionInterface
{
    public function getCollection(): string;

    /**
     * @return class-string|ModelInCollectionInterface
     */
    public function getModelInstanceClass(): string;
}