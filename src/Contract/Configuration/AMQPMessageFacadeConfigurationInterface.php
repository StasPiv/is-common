<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration;

interface AMQPMessageFacadeConfigurationInterface
{
    /**
     * @return class-string
     */
    public function getModelInstance(): string;
}