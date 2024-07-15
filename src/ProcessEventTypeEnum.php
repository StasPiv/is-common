<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

enum ProcessEventTypeEnum
{
    case MessageReceived;

    case Success;

    case Fail;

    case MessagePublished;

    case MessageAcked;
}
