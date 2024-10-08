<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MoveScoreUpdaterInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ScoreProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ScoreWorkerProcessTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

abstract class AbstractMoveScoreUpdater implements MoveScoreUpdaterInterface
{
    final public function __construct(
        private readonly EventManagerInterface                   $eventManager,
        private readonly ScoreProcessorInterface $scoreProcessor,
    ) {
    }

    public function updateMoveScore(MoveScoreModel $moveScoreModel): void
    {
        $fen = $this->getFen($moveScoreModel->getMove());

        if ($existingScore = $this->getScore($moveScoreModel)) {
            $this->eventManager->notify(
                ScoreWorkerProcessTypeEnum::ScoreExists, new DataAwareProcessDataModel(['fen' => $fen])
            );
            $this->scoreProcessor->processExistingScore($fen, $existingScore);

            return;
        }

        $this->eventManager->notify(
            ScoreWorkerProcessTypeEnum::ScoreNotExists, new DataAwareProcessDataModel(['fen' => $fen])
        );

        $score = $this->scoreProcessor->processNewScore($fen);

        if ($score === null) {
            $this->eventManager->notify(
                ScoreWorkerProcessTypeEnum::ScoreNotProcessed, new DataAwareProcessDataModel(['fen' => $fen])
            );

            return;
        }

        $this->updateScoreColumn($moveScoreModel, $score);
    }

    abstract protected function updateScoreColumn(MoveScoreModel $moveScoreModel, int $score): void;

    abstract protected function getFen(MoveMessageModel $moveSavableMessageModel): string;

    abstract protected function getScore(MoveScoreModel $moveScoreModel): ?int;
}
