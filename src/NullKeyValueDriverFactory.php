<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeySaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyValueDriverFactoryInterface;

class NullKeyValueDriverFactory implements KeyValueDriverFactoryInterface
{
    public function createKeyFinder(): KeyFinderInterface
    {
        return new NullKeyValueDriver();
    }

    public function createKeySaver(): KeySaverInterface
    {
        return new NullKeyValueDriver();
    }
}