<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\CollectionFinderException;
use StanislavPivovartsev\InterestingStatistics\Common\Model\GameMessageModel;

class GameModelFinder implements CollectionFinderInterface
{
    public function __construct(
        private readonly MysqlConnectionInterface $mysqlConnection,
        private readonly MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
    ) {
    }

    public function modelExists(ModelInCollectionInterface $model): bool
    {
        if (!$model instanceof GameMessageModel) {
            throw new CollectionFinderException('GameModelFinder can work only with GameModel');
        }

        $sql = $this->mysqlSelectQueryBuilder->buildSelectSql($model->getCollection(), ['id'], ['pgn_hash' => $model->getPgnHash()]);
        $this->mysqlConnection->query($sql);

        return $this->mysqlConnection->getAffectedRows() > 0;
    }
}