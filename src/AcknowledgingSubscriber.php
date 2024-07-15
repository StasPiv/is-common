<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

class AcknowledgingSubscriber implements SubscriberInterface
{
    public function update(ProcessDataInterface $data): void
    {
        $data->getMessage()->ack();
    }
}