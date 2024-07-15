<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessagePublishedProcessDataInterface;

class MessagePublishedProcessData extends AbstractProcessData implements MessagePublishedProcessDataInterface
{
    final public function __construct(
        protected MessageInterface $message,
    ) {
        parent::__construct(ProcessEventTypeEnum::MessagePublished, $this->message);
    }
}