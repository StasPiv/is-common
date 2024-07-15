<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use RuntimeException;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSavableModelBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\PgnSaveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PgnHashGeneratorInterface;

class GameModelBuilder implements CollectionSavableModelBuilderInterface
{
    public function __construct(
        private readonly IdGeneratorStrategyInterface $idGeneratorStrategy,
        private readonly PgnHashGeneratorInterface    $pgnHashGenerator,
        private readonly MessageModelFromMessageBuilderInterface $messageModelBuilder,
    ) {
    }

    public function buildCollectionSavableModel(MessageInterface $message): ModelInCollectionInterface
    {
        $pgnSaveMessageModel = $this->messageModelBuilder->buildMessageModelFromMessage($message);

        if (!$pgnSaveMessageModel instanceof PgnSaveMessageModel) {
            throw new RuntimeException('This builder can work only with message containing ' . PgnSaveMessageModel::class);
        }

        return new GameModel(
            $this->idGeneratorStrategy->generateId(),
            $pgnSaveMessageModel->getPgn(),
            $this->pgnHashGenerator->generatePgnHash($pgnSaveMessageModel->getPgn()),
        );
    }
}
