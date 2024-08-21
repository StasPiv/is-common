<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelInterface extends StringInterface
{
    public function getDataForSerialize(): array;

    public static function getInstance(...$data): static;
}