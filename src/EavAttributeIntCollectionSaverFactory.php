<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

class EavAttributeIntCollectionSaverFactory extends AbstractCollectionSaverFactory
{
    protected function getCollectionSaverClassName(): string
    {
        return EavAttributeIntCollectionSaver::class;
    }
}