<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\PlayerModel;

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
        return MoveMessageModel::class;
    }

    protected function getUniqueCriteria(ModelInCollectionInterface|MoveMessageModel $model): array
    {
        $game = $this->gameFinder->findUnique($model->getGame());

        return [
            'gameId' => $game->getId(),
            'moveNumber' => $model->getMoveNumber(),
            'side' => $model->getSide(),
        ];
    }

    protected function buildModelFromDb(array $assoc): ModelInCollectionInterface
    {
        $assoc['game'] = $this->gameFinder->find($assoc['gameId']);
        unset($assoc['gameId']);
        $assoc['moveNumber'] = (int) $assoc['moveNumber'];
        $assoc['player'] = new PlayerModel(
            $assoc['player'],
            (int)$assoc['playerElo'],
        );
        $assoc['opponent'] = new PlayerModel(
            $assoc['opponent'],
            (int)$assoc['opponentElo'],
        );
        unset($assoc['playerElo']);
        unset($assoc['opponentElo']);

        return parent::buildModelFromDb($assoc);
    }
}