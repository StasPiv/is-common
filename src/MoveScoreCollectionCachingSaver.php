<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeyFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\KeySaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveEvaluationModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class MoveScoreCollectionCachingSaver extends MoveScoreCollectionSaver
{
    public function __construct(
        StorageSaverInterface $storageSaver,
        CollectionSaverInterface $moveCollectionSaver,
        private readonly KeyFinderInterface $keyFinder,
        private readonly KeySaverInterface $keySaver,
    ) {
        parent::__construct($storageSaver, $moveCollectionSaver);
    }

    public function saveModel(MoveScoreModel|ModelInCollectionInterface $model): bool
    {
        $cachedKey = $model->getMove()->getFenBefore() . '-' . $model->getMove()->getMoveNotation();

        if (!$this->keyFinder->exists($cachedKey)) {
            $this->keySaver->saveValue(
                $cachedKey,
                (string) new MoveEvaluationModel(
                    $model->getMove()->getFenBefore(),
                    $model->getMove()->getMoveNotation(),
                    '',
                    $model->getScoreBefore(),
                    $model->getScoreAfter(),
                )
            );
        }

        return parent::saveModel($model);
    }

}