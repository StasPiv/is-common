<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveScoreUpdaterFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveScoreUpdaterInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreDiffCalculatorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreProcessorFactoryInterface;

class MoveScoreAfterUpdaterFactory implements MoveScoreUpdaterFactoryInterface
{
    final public function __construct(
        private readonly EventManagerFactoryInterface                   $eventManagerFactory,
        private readonly ScoreDiffCalculatorFactoryInterface            $scoreDiffCalculatorFactory,
        private readonly ScoreProcessorFactoryInterface $scoreProcessorFactory,
    ) {
    }

    public function createMoveScoreUpdater(): MoveScoreUpdaterInterface
    {
        return new MoveScoreAfterUpdater(
            $this->eventManagerFactory->createEventManager(),
            $this->scoreDiffCalculatorFactory->createScoreDiffCalculator(),
            $this->scoreProcessorFactory->createScoreProcessor(),
        );
    }
}