<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelFromStringBuilderFactoryInterface
{
    public function createBuilder(): MessageModelFromStringBuilderInterface;
}