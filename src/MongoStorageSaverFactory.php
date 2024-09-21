<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\MongoConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;

class MongoStorageSaverFactory implements Contract\StorageSaverFactoryInterface
{
    public function __construct(
        private readonly MongoConnectionConfigurationInterface $connectionConfiguration,
        private readonly EventManagerFactoryInterface $eventManagerFactory,
    ) {
    }

    public function createStorageSaver(): StorageSaverInterface
    {
        $uri = $this->connectionConfiguration->getConnectionUri();

        $apiVersion = new ServerApi(ServerApi::V1);

        $client = new Client($uri, [], ['serverApi' => $apiVersion]);
        $database = $client->selectDatabase($this->connectionConfiguration->getDatabase());

        return new MongoStorageSaver($database, $this->eventManagerFactory->createEventManager());
    }
}