<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ScoreProcessorFactoryInterface
{
    public function createScoreProcessor(): ScoreProcessorInterface;
}