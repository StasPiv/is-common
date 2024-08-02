<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveSavableMessageModel;

class MoveCollectionFinder extends AbstractMysqlFinder
{
    public function __construct(
        MysqlConnectionInterface $mysqlConnection,
        MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
        private readonly CollectionFinderInterface $gameFinder,
    ) {
        parent::__construct($mysqlConnection, $mysqlSelectQueryBuilder);
    }


    public function getCollection(): string
    {
        return 'moves';
    }

    public function getModelInstanceClass(): string
    {
        return MoveSavableMessageModel::class;
    }

    protected function getUniqueCriteria(ModelInCollectionInterface|MoveSavableMessageModel $model): array
    {
        $game = $this->gameFinder->findUnique($model->getGameModel());

        return [
            'gameId' => $game->getId(),
            'moveNumber' => $model->getMoveNumber(),
            'side' => $model->getSide(),
        ];
    }
}