<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveScoreUpdaterFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveScoreUpdaterInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreDiffCalculatorFactoryInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreProcessorFactoryInterface;

class MoveScoreBeforeUpdaterFactory implements MoveScoreUpdaterFactoryInterface
{
    final public function __construct(
        private readonly EventManagerFactoryInterface                   $eventManagerFactory,
        private readonly ScoreDiffCalculatorFactoryInterface            $scoreDiffCalculatorFactory,
        private readonly ScoreProcessorFactoryInterface $scoreProcessorFactory,
    ) {
    }

    public function createMoveScoreUpdater(): MoveScoreUpdaterInterface
    {
        return new MoveScoreBeforeUpdater(
            $this->eventManagerFactory->createEventManager(),
            $this->scoreDiffCalculatorFactory->createScoreDiffCalculator(),
            $this->scoreProcessorFactory->createScoreProcessor(),
        );
    }
}