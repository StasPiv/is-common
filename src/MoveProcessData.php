<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;

class MoveProcessData extends AbstractProcessData implements MoveProcessDataInterface
{
    final public function __construct(
        protected MessageInterface                  $message,
        private readonly MoveMessageModel $moveMessageModel,
    ) {
        parent::__construct(ProcessEventTypeEnum::Success, $this->message);
    }

    public function getMoveMessageModel(): MoveMessageModel
    {
        return $this->moveMessageModel;
    }

    public function __toString(): string
    {
        return serialize($this->getMoveMessageModel());
    }
}