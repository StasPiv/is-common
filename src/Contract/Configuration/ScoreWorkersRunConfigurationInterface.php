<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface ScoreWorkersRunConfigurationInterface
{
    public function getContainerImagesForRun(): array;
}