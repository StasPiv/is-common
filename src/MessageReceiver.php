<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelExtractorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\ProcessorException;

class MessageReceiver implements MessageReceiverInterface
{
    public function __construct(
        private readonly EventManagerInterface                  $eventManager,
        private readonly MessageProcessorInterface              $messageProcessor,
        private readonly MessageModelExtractorInterface $messageModelExtractor,
    ) {
    }

    public function onReceive(MessageInterface $message): void
    {
        $this->eventManager->notify(ProcessEventTypeEnum::MessageReceived, $message);

        try {
            $messageModel = $this->messageModelExtractor->extractMessageModelFromMessage($message);
            $this->messageProcessor->process($messageModel);
            $this->eventManager->notify(ProcessEventTypeEnum::Success, $message);
        } catch (ProcessorException $processorException) {
            $this->eventManager->notify(ProcessEventTypeEnum::Fail, $processorException);
        }
    }
}