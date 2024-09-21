<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MongoConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;

class MongoStorageSaverFactory implements Contract\StorageSaverFactoryInterface
{
    public function __construct(
        private readonly MongoConnectionConfigurationInterface $connectionConfiguration,
    ) {
    }

    public function createStorageSaver(): StorageSaverInterface
    {
        // Replace the placeholder with your Atlas connection string
        $uri = $this->connectionConfiguration->getConnectionUri();

        // Specify Stable API version 1
        $apiVersion = new ServerApi(ServerApi::V1);

        // Create a new client and connect to the server
        $client = new Client($uri, [], ['serverApi' => $apiVersion]);
        $database = $client->selectDatabase($this->connectionConfiguration->getDatabase());

        return new MongoStorageSaver($database);
    }
}