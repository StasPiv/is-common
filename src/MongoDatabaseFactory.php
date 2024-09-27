<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Client;
use MongoDB\Database;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MongoConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MongoDatabaseFactoryInterface;

class MongoDatabaseFactory implements MongoDatabaseFactoryInterface
{
    public function __construct(
        private readonly MongoConnectionConfigurationInterface $mongoConnectionConfiguration,
    ) {
    }

    public function createDatabase(): Database
    {
        $client = new Client($this->mongoConnectionConfiguration->getConnectionUri());

        return $client->selectDatabase($this->mongoConnectionConfiguration->getDatabase());
    }
}