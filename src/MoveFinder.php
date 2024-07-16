<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\CollectionFinderException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveSavableModel;

class MoveFinder implements CollectionFinderInterface
{
    public function __construct(
        private readonly MysqlConnectionInterface $mysqlConnection,
        private readonly MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
    ) {
    }

    public function modelExists(ModelInCollectionInterface $model): bool
    {
        if (!$model instanceof MoveSavableModel) {
            throw new CollectionFinderException('MoveFinder can work only with MoveSavableModel');
        }

        $sql = $this->mysqlSelectQueryBuilder->buildSelectSql(
            $model->getCollection(),
            ['id'],
            [
                'game_id' => $model->getGameId(),
                'move_number' => $model->getMoveNumber(),
                'side' => $model->getSide(),
            ]
        );
        $this->mysqlConnection->query($sql);

        return $this->mysqlConnection->getAffectedRows() > 0;
    }
}