<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;

class PublisherFactory implements PublisherFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface $amqpConnectionFactory,
        private readonly PublisherConfigurationInterface $publisherConfiguration,
    ) {
    }

    public function createPublisher(): PublisherInterface
    {
        return new AMQPPublisher(
            $this->amqpConnectionFactory->createAMQPChannel(),
            $this->publisherConfiguration->getQueue(),
            $this->createMessageModelExtractor(),
        );
    }

    private function createMessageModelExtractor(): MessageModelExtractorInterface
    {
        return new MessageModelExtractor($this->createMessageModelFromStringBuilder());
    }

    private function createMessageModelFromStringBuilder(): MessageModelFromStringBuilderInterface
    {
        return new JsonDecodeMessageModelBuilder();
    }
}