<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;

class ChessMqPublisherFactory implements Contract\PublisherFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionConfigurationInterface $connectionConfiguration,
        private readonly PublisherConfigurationInterface      $publisherConfiguration,
    ) {
    }

    public function createPublisher(): PublisherInterface
    {
        return new ChessMqPublisher(
            $this->connectionConfiguration,
            $this->publisherConfiguration->getQueue(),
        );
    }
}