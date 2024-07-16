<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface EngineConfigurationInterface
{
    public function getName(): string;

    public function getOptions(): array;

    public function getMoveTime(): int;

    public function getPathToPolyglot(): string;
}
