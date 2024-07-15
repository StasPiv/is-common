<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageAckedProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;

class MessageAckedProcessData extends AbstractProcessData implements MessageAckedProcessDataInterface
{
    final public function __construct(
        protected MessageInterface $message,
    ) {
        parent::__construct(ProcessEventTypeEnum::MessageAcked, $this->message);
    }
}