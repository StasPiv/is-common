<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveSavableMessageModel;

class MoveCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'moves';
    }

    public function getModelInstanceClass(): string
    {
        return MoveSavableMessageModel::class;
    }
}