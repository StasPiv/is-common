<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface AMQPMessageFacadeBuilderFactoryInterface
{
    public function createAMQPMessageFacadeBuilder(): AMQPMessageFacadeBuilderInterface;
}