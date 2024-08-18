<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface QueueDeclareProcessorFactoryInterface
{
    public function createQueueDeclareProcessor(): QueueDeclareProcessorInterface;
}