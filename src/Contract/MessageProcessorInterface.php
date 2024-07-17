<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageProcessorInterface
{
    public function process(MessageModelInterface $messageModel): void;
}