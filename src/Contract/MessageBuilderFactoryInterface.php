<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageBuilderFactoryInterface
{
    public function createMessageBuilder(): MessageBuilderInterface;
}