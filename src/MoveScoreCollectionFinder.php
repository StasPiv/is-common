<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlSelectQueryBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class MoveScoreCollectionFinder extends AbstractMysqlFinder
{
    public function __construct(
        MysqlConnectionInterface $mysqlConnection,
        MysqlSelectQueryBuilderInterface $mysqlSelectQueryBuilder,
        private readonly CollectionFinderInterface $moveCollectionFinder,
    ) {
        parent::__construct($mysqlConnection, $mysqlSelectQueryBuilder);
    }


    public function getCollection(): string
    {
        return 'move_scores';
    }

    public function getModelInstanceClass(): string
    {
        return MoveScoreModel::class;
    }

    protected function getUniqueCriteria(ModelInCollectionInterface|MoveScoreModel $model): array
    {
        $existingMoveModel = $this->moveCollectionFinder->findUnique($model->getMove());

        return [
            'id' => $existingMoveModel->getId(),
        ];
    }

    protected function buildModelFromDb(array $assoc): ModelInCollectionInterface
    {
        $assoc['moveModel'] = $this->moveCollectionFinder->find($assoc['id']);

        return parent::buildModelFromDb($assoc);
    }
}