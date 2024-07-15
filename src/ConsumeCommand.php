<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;

class ConsumeCommand implements CommandInterface
{
    public function __construct(
        private readonly ConsumerInterface $consumer,
    ) {
    }

    public function execute(): void
    {
        $this->consumer->consume();
    }
}
