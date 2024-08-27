<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ModelInCollectionInterface extends SavableModelInterface
{
    public function getId(): string;

    public function setId(string $id): void;

    public function hasId(): bool;
}