<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ConsumerFactoryInterface
{
    public function createConsumer(): ConsumerInterface;
}