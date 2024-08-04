<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

enum ScoreWorkerProcessTypeEnum implements EventTypeInterface
{
    use EventTypeTrait;

    case ScoreExists;
    case ScoreNotExists;
    case ScoreNotProcessed;
}
