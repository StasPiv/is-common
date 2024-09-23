<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface WorkersRunConfigurationInterface
{
    public function getContainerImagesForRun(): array;
}