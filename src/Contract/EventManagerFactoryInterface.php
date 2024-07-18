<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface EventManagerFactoryInterface
{
    public function createEventManager(): EventManagerInterface;
}