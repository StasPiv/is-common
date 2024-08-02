<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\ModelForSaveBuilderException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveSavableMessageModel;

class MoveModelForSaveBuilder extends StandardModelForSaveBuilder
{
    public function __construct(
        IdGeneratorStrategyInterface $idGeneratorStrategy,
        private readonly CollectionFinderInterface $gameCollectionFinder,
    ) {
        parent::__construct($idGeneratorStrategy);
    }

    public function buildModelForInsert(ModelInCollectionInterface|MoveSavableMessageModel $model): void
    {
        parent::buildModelForInsert($model);

        $existingGame = $this->gameCollectionFinder->findUnique($model->getGame());

        if (!$existingGame instanceof GameMessageModel) {
            throw new ModelForSaveBuilderException(
                'Impossible to save move, because game does not exist: ' . $model->getGame(),
            );
        }

        $model->setGame($existingGame);
    }

    public function buildModelForUpdate(
        ModelInCollectionInterface|MoveSavableMessageModel $model,
        ModelInCollectionInterface|MoveSavableMessageModel $existingModel
    ): void {
        parent::buildModelForUpdate($model, $existingModel);

        $model->setGame($existingModel->getGame());
    }
}