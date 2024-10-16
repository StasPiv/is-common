<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Model\ReportModel;

class ReportMongoCollectionFinder extends AbstractMongoCollectionFinder
{
    public function getCollection(): string
    {
        return 'reports';
    }

    /**
     * @inheritDoc
     */
    public function getModelInstanceClass(): string
    {
        return ReportModel::class;
    }

    protected function getUniqueCriteria(ModelInCollectionInterface|ReportModel $model): array
    {
        return [
            'reportParamsHash' => $model->getReportParamsHash(),
            'uploadId' => $model->getUploadId(),
        ];
    }
}