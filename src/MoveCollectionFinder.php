<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveSavableMessageModel;

class MoveCollectionFinder extends AbstractMysqlFinder
{
    public function getCollection(): string
    {
        return 'moves';
    }

    public function getModelInstance(): string
    {
        return MoveSavableMessageModel::class;
    }
}