<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;

class GameModelCollectionFactory extends MysqlCollectionFactory
{
    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new GameModelFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }
}
