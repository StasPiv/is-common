<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface MongoConnectionConfigurationInterface
{
    public function getConnectionUri(): string;

    public function getDatabase(): string;
}