<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

enum ProcessEventTypeEnum implements EventTypeInterface
{
    use EventTypeTrait;

    case MessageReceived;
    case Success;
    case Fail;
    case MessagePublished;
    case MessageAcked;
    case MessagePreparedForPublish;
    case ModelSaveFailed;
    case ModelFound;
    case ModelNotFound;
    case ModelUpdated;
    case ModelDeleted;
    case ModelPublished;
    case MessageBatchPreparedForPublish;
    case QueueCleaned;
    case QueueDeleted;
}
