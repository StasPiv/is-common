<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeCollectionSaverFactory extends AbstractCollectionSaverFactory
{
    protected function getCollectionSaverClassName(): string
    {
        return EavAttributeCollectionSaver::class;
    }
}