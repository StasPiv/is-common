<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;

class MessageReceiver implements Contract\MessageReceiverInterface
{
    public function __construct(
        private readonly EventManagerInterface                  $eventManager,
        private readonly MessageProcessorInterface              $messageProcessor,
        private readonly ProcessDataBuilderInterface $processDataBuilder,
    ) {
    }

    public function onReceive(MessageInterface $message): void
    {
        $this->eventManager->notify(
            $this->processDataBuilder->buildMessageReceivedProcessData($message),
        );

        $this->messageProcessor->process($message);
    }
}