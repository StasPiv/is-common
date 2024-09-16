<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

class ChessMqMessageFacade implements Contract\MessageInterface
{
    public function __construct(
        private readonly string $message,
        private readonly string $modelInstance,
    ) {
    }

    public function ack(): void
    {
        // TODO: Implement ack() method.
    }

    /**
     * @inheritDoc
     */
    public function getModelInstance(): string
    {
        return $this->modelInstance;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}