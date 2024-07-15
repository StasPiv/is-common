<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CommandFactoryInterface
{
    public function createCommand(): CommandInterface;
}