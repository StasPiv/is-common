<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceivedProcessDataInterface;

class MessageReceivedProcessData extends AbstractProcessData implements MessageReceivedProcessDataInterface
{
    final public function __construct(
        protected MessageInterface $message,
    ) {
        parent::__construct(ProcessEventTypeEnum::MessageReceived, $this->message);
    }
}