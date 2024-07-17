<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\PublisherConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublishingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class PublishingSubscriberFactory implements PublishingSubscriberFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface $amqpConnectionFactory,
        private readonly LoggingSubscriberFactoryInterface $loggingSubscriberFactory,
        private readonly AMQPMessageFacadeConfigurationInterface $publisherAmqpConfiguration,
        private readonly PublisherConfigurationInterface $publisherConfiguration,
    ) {
    }

    public function createPublishingSubscriber(): SubscriberInterface
    {
        return new PublishingSubscriber(
            $this->createPublisher(),
            $this->createPublisherEventManager(),
            $this->createAMQPPublishedMessageFacadeBuilder(),
        );
    }

    private function createPublisher(): PublisherInterface
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
        return new MessageModelFromStringBuilder();
    }

    private function createPublisherEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessagePublished,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessagePublished)
        );

        return $eventManager;
    }

    private function createAMQPPublishedMessageFacadeBuilder(): AMQPMessageFacadeBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->publisherAmqpConfiguration);
    }
}