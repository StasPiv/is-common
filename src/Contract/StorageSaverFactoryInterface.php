<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface StorageSaverFactoryInterface
{
    public function createStorageSaver(): StorageSaverInterface;
}