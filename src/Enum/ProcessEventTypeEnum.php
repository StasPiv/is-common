<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

enum ProcessEventTypeEnum
{
    case MessageReceived;

    case Success;

    case Fail;

    case MessagePublished;

    case MessageAcked;

    case ModelCreated;

    case ModelSaveFailed;

    case ModelFound;

    case ModelNotFound;

    case ModelUpdated;

    case ModelDeleted;
}
