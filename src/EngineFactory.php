<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\EngineConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EngineFactoryInterface;
use StasPiv\ChessBestMove\Model\EngineConfiguration;
use StasPiv\ChessBestMove\Service\ChessBestMove;

class EngineFactory implements EngineFactoryInterface
{
    public function __construct(
        private readonly EngineConfigurationInterface $engineConfiguration,
    ) {
    }

    public function createChessBestMove(): ChessBestMove
    {
        return new ChessBestMove($this->createEngineConfiguration());
    }

    public function createEngineConfiguration(): EngineConfiguration
    {
        $testEngineConfiguration = new EngineConfiguration($this->engineConfiguration->getName());

        foreach ($this->engineConfiguration->getOptions() as $name => $value) {
            $testEngineConfiguration->addOption($name, $value);
        }

        $testEngineConfiguration->setPathToPolyglotRunDir($this->engineConfiguration->getPathToPolyglot());

        return $testEngineConfiguration;
    }
}