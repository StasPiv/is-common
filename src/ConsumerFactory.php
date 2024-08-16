<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPConnectionFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\AMQPMessageFacadeBuilderFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;

class ConsumerFactory implements ConsumerFactoryInterface
{
    /**
     * @param array<\StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberFactoryInterface> $successSubscriberFactories
     */
    public function __construct(
        private readonly AMQPConnectionFactoryInterface           $amqpConnectionFactory,
        private readonly SubscriberFactoryInterface               $loggingSubscriberFactory,
        private readonly AMQPConsumerConfigurationInterface       $consumerConfiguration,
        private readonly MessageProcessorFactoryInterface         $messageProcessorFactory,
        private readonly AMQPMessageFacadeBuilderFactoryInterface $amqpMessageFacadeBuilderFactory,
        private array                                    $successSubscriberFactories,
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
            $this->loggingSubscriberFactory->createSubscriber()
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Success,
            $this->loggingSubscriberFactory->createSubscriber()
        );
        $eventManager->subscribe(
            ProcessEventTypeEnum::Fail,
            $this->loggingSubscriberFactory->createSubscriber()
        );

        array_walk(
            $this->successSubscriberFactories,
            fn (SubscriberFactoryInterface $subscriberFactory) =>
                $eventManager->subscribe(ProcessEventTypeEnum::Success, $subscriberFactory->createSubscriber()),
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