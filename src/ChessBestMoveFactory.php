<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\EngineConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ChessBestMoveFactoryInterface;
use StasPiv\ChessBestMove\Model\EngineConfiguration;
use StasPiv\ChessBestMove\Service\ChessBestMove;

class ChessBestMoveFactory implements ChessBestMoveFactoryInterface
{
    public function __construct(
        private readonly EngineConfigurationInterface $engineConfiguration,
    ) {
    }

    public function createChessBestMove(): ChessBestMove
    {
        return new ChessBestMove($this->createEngineConfiguration());
    }

    private function createEngineConfiguration(): EngineConfiguration
    {
        $testEngineConfiguration = new EngineConfiguration($this->engineConfiguration->getName());

        foreach ($this->engineConfiguration->getOptions() as $name => $value) {
            $testEngineConfiguration->addOption($name, $value);
        }

        $testEngineConfiguration->setPathToPolyglotRunDir($this->engineConfiguration->getPathToPolyglot());

        return $testEngineConfiguration;
    }
}