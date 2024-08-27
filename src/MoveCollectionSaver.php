<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\StorageSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;

class MoveCollectionSaver extends AbstractCollectionSaver
{
    public function __construct(
        StorageSaverInterface $storageSaver,
    ) {
        parent::__construct($storageSaver);
    }

    public function getCollection(): string
    {
        return 'moves';
    }

    public function getModelInstanceClass(): string
    {
        return MoveMessageModel::class;
    }
}