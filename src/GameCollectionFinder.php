<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

class GameCollectionFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'games';
    }

    public function getModelInstance(): string
    {
        return GameMessageModel::class;
    }
}