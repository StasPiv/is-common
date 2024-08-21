<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;

class JsonDecodeMessageBuilderFactory implements Contract\MessageModelFromStringBuilderFactoryInterface
{
    public function createBuilder(): MessageModelFromStringBuilderInterface
    {
        return new JsonDecodeMessageModelBuilder();
    }
}