<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SuccessfulProcessDataInterface;

class SuccessfulProcessData extends AbstractProcessData implements SuccessfulProcessDataInterface
{
    final public function __construct(
        protected MessageInterface                  $message,
        private readonly ModelInCollectionInterface $modelInCollection,
        private readonly string $infoMessage,
    ) {
        parent::__construct(ProcessEventTypeEnum::Success, $this->message);
    }

    public function getModelInCollection(): ModelInCollectionInterface
    {
        return $this->modelInCollection;
    }

    public function getInfoMessage(): string
    {
        return $this->infoMessage;
    }

    public function __toString(): string
    {
        return serialize($this->modelInCollection);
    }
}