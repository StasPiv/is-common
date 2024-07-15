<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface PublisherConfigurationInterface
{
    public function getQueue(): string;
}
