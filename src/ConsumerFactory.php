<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\LoggingSubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class ConsumerFactory implements ConsumerFactoryInterface
{
    public function __construct(
        private readonly AMQPConnectionFactoryInterface $amqpConnectionFactory,
        private readonly LoggingSubscriberFactoryInterface $loggingSubscriberFactory,
        private readonly AMQPConsumerConfigurationInterface $consumerConfiguration,
        private readonly AMQPMessageFacadeConfigurationInterface $receiverAmqpConfiguration,
        private readonly MessageProcessorInterface $messageProcessor,
    ) {
    }

    public function createConsumer(): ConsumerInterface
    {
        return new AMQPConsumer(
            $this->amqpConnectionFactory->createAMQPConnection(),
            $this->amqpConnectionFactory->createAMQPChannel(),
            $this->createAMQPReceivedMessageFacadeBuilder(),
            $this->consumerConfiguration,
            $this->createMessageReceiver(),
        );
    }

    private function createAMQPReceivedMessageFacadeBuilder(): AMQPMessageFacadeBuilderInterface
    {
        return new AMQPMessageFacadeBuilder($this->receiverAmqpConfiguration);
    }

    private function createMessageReceiver(): MessageReceiverInterface
    {
        return new MessageReceiver(
            $this->createReceiverEventManager(),
            $this->messageProcessor,
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
}