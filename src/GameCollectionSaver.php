<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

class GameCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'games';
    }

    public function getModelInstanceClass(): string
    {
        return GameMessageModel::class;
    }
}