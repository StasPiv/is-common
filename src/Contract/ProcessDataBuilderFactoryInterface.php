<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ProcessDataBuilderFactoryInterface
{
    public function createProcessDataBuilder(): ProcessDataBuilderInterface;
}