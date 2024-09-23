<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\GameUserModel;

class GameUserCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'game_user';
    }

    public function getModelInstanceClass(): string
    {
        return GameUserModel::class;
    }
}