<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class MoveScoreCollectionSaver extends AbstractCollectionSaver
{
    public function __construct(
        StorageSaverInterface        $storageSaver,
    ) {
        parent::__construct($storageSaver);
    }


    public function getCollection(): string
    {
        return 'move_scores';
    }

    public function getModelInstanceClass(): string
    {
        return MoveScoreModel::class;
    }
}