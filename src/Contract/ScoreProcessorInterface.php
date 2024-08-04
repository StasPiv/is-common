<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface ScoreProcessorInterface
{
    public function processExistingScore(string $fen, int $existingScore): void;

    public function processNewScore(string $fen): ?int;
}