<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ModelForSaveBuilderFactoryInterface
{
    public function createModelForSaveBuilder(): ModelForSaveBuilderInterface;
}