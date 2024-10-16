<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\ReportModel;

class ReportCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'reports';
    }

    public function getModelInstanceClass(): string
    {
        return ReportModel::class;
    }
}
