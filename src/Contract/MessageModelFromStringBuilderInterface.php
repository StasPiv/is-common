<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelFromStringBuilderInterface
{
    public function buildMessageModelFromString(string $string, string $modelClass): MessageModelInterface;
}