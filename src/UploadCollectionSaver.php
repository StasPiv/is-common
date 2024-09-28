<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Model\UploadModel;

class UploadCollectionSaver extends AbstractCollectionSaver
{
    public function getCollection(): string
    {
        return 'uploads';
    }

    public function getModelInstanceClass(): string
    {
        return UploadModel::class;
    }
}