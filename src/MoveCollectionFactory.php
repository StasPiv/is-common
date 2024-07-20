<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;

class MoveCollectionFactory extends AbstractMysqlCollectionFactory
{
    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new MoveCollectionFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new MoveCollectionSaver(
            $this->createMysqlConnection(),
            $this->createMysqlInsertQueryBuilder(),
        );
    }
}
