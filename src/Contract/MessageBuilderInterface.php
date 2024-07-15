<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageBuilderInterface
{
    public function buildMessageFromStringObject(StringInterface $stringObject): MessageInterface;
}