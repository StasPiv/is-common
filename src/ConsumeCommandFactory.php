<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CommandInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerFactoryInterface;

class ConsumeCommandFactory implements CommandFactoryInterface
{
    public function __construct(
        protected ConsumerFactoryInterface $consumerFactory,
    ) {
    }

    public function createCommand(): CommandInterface
    {
        return new ConsumeCommand($this->consumerFactory->createConsumer());
    }
}