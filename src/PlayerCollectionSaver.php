<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\PlayerModel;

class PlayerCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'players';
    }

    public function getModelInstanceClass(): string
    {
        return PlayerModel::class;
    }
}