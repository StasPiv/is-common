<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface PublisherInterface
{
    public function publish(MessageInterface $message): void;
}
