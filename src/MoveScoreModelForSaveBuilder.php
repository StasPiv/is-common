<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\IdGeneratorStrategyInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\ModelForSaveBuilderException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class MoveScoreModelForSaveBuilder extends StandardModelForSaveBuilder
{
    public function __construct(
        IdGeneratorStrategyInterface $idGeneratorStrategy,
        private readonly CollectionFinderInterface $moveCollectionFinder,
    ) {
        parent::__construct($idGeneratorStrategy);
    }

    public function buildModelForInsert(ModelInCollectionInterface|MoveScoreModel $model): void
    {
        $existingMove = $this->moveCollectionFinder->findUnique($model->getMove());

        if (!$existingMove instanceof MoveMessageModel) {
            throw new ModelForSaveBuilderException(
                'MoveScore needs existing move for save: ' . $model->getMove(),
            );
        }

        $model->setId($existingMove->getId());
    }
}
