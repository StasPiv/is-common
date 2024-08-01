<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface PublisherFactoryInterface
{
    public function createPublisher(): PublisherInterface;
}