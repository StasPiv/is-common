<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;

class MoveScoreCollectionFactory extends AbstractMysqlCollectionFactory
{
    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new MoveScoreFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }

    public function createCollectionSaver(): CollectionSaverInterface
    {
        return new MoveScoreSaver(
            $this->createMysqlConnection(),
            $this->createMysqlInsertQueryBuilder(),
        );
    }
}