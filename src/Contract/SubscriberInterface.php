<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface SubscriberInterface
{
    public function update(ProcessDataInterface $data): void;
}
