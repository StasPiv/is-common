<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageReceiverInterface
{
    public function onReceive(MessageInterface $message): void;
}