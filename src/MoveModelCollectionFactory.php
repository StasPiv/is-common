<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;

class MoveModelCollectionFactory extends MysqlCollectionFactory
{
    public function createCollectionFinder(): CollectionFinderInterface
    {
        return new MoveFinder(
            $this->createMysqlConnection(),
            $this->createMysqlSelectQueryBuilder(),
        );
    }
}
