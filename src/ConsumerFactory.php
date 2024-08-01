<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class ConsumerFactory implements ConsumerFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface           $amqpConnectionFactory,
        private readonly LoggingSubscriberFactoryInterface        $loggingSubscriberFactory,
        private readonly AMQPConsumerConfigurationInterface       $consumerConfiguration,
        private readonly MessageProcessorFactoryInterface         $messageProcessorFactory,
        private readonly AMQPMessageFacadeBuilderFactoryInterface $amqpMessageFacadeBuilderFactory,
    ) {
    }

    public function createConsumer(): ConsumerInterface
    {
        return new AMQPConsumer(
            $this->amqpConnectionFactory->createAMQPConnection(),
            $this->amqpConnectionFactory->createAMQPChannel(),
            $this->amqpMessageFacadeBuilderFactory->createAMQPMessageFacadeBuilder(),
            $this->consumerConfiguration,
            $this->createMessageReceiver(),
        );
    }

    private function createMessageReceiver(): MessageReceiverInterface
    {
        return new MessageReceiver(
            $this->createReceiverEventManager(),
            $this->messageProcessorFactory->createMessageProcessor(),
            $this->createMessageModelExtractor(),
        );
    }

    private function createReceiverEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessageReceived,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessageReceived)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Success,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::Success)
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Fail,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::Fail)
        );
        $eventManager->subscribe(ProcessEventTypeEnum::Success, $this->createAcknowledgingSubscriber());

        return $eventManager;
    }

    private function createAcknowledgingSubscriber(): SubscriberInterface
    {
        return new AcknowledgingSubscriber(
            $this->createAcknowledgingEventManager(),
        );
    }

    private function createAcknowledgingEventManager(): EventManagerInterface
    {
        $eventManager = new EventManager();

        $eventManager->subscribe(
            ProcessEventTypeEnum::MessageAcked,
            $this->loggingSubscriberFactory->createLoggingSubscriber(ProcessEventTypeEnum::MessageAcked)
        );

        return $eventManager;
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