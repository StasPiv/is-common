<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface KeyValueDriverFactoryInterface
{
    public function createKeyFinder(): KeyFinderInterface;

    public function createKeySaver(): KeySaverInterface;
}