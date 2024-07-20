<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;

class GameCollectionFactory extends AbstractMysqlCollectionFactory
{
    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new GameCollectionFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new GameCollectionSaver(
            $this->createMysqlConnection(),
            $this->createMysqlInsertQueryBuilder(),
        );
    }
}
