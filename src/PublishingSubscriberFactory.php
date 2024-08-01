<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublishingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class PublishingSubscriberFactory implements PublishingSubscriberFactoryInterface
{
    public function __construct(
        private readonly PublisherFactoryInterface $publisherFactory,
        private readonly LoggingSubscriberFactoryInterface $loggingSubscriberFactory,
        private readonly AMQPMessageFacadeBuilderFactoryInterface $amqpMessageFacadeBuilderFactory,
    ) {
    }

    public function createPublishingSubscriber(): SubscriberInterface
    {
        return new PublishingSubscriber(
            $this->publisherFactory->createPublisher(),
            $this->createPublishingSubscriberEventManager(),
            $this->amqpMessageFacadeBuilderFactory->createAMQPMessageFacadeBuilder(),
        );
    }

    private function createPublishingSubscriberEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessagePublished,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessagePublished)
        );

        return $eventManager;
    }
}