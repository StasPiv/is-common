<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ModelInCollectionInterface extends SavableModelInterface
{
    public function getCollection(): string;

    public function getId(): string;
}