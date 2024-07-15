<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

interface CollectionSavableModelBuilderInterface
{
    public function buildCollectionSavableModel(MessageInterface $message): ModelInCollectionInterface;
}