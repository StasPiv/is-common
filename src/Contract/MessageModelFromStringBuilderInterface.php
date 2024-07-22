<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelFromStringBuilderInterface
{
    /**
     * @param class-string|\StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractMessageModel $modelClass
     */
    public function buildMessageModelFromString(string $string, string $modelClass): MessageModelInterface;
}