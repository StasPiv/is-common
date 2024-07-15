<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\FailedProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;

class FailedProcessData extends AbstractProcessData implements FailedProcessDataInterface
{
    final public function __construct(
        protected MessageInterface $message,
        private readonly string           $errorMessage,
    ) {
        parent::__construct(ProcessEventTypeEnum::Fail, $this->message);
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}