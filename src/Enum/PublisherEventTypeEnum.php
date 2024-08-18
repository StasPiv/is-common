<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

enum PublisherEventTypeEnum implements EventTypeInterface
{
    use EventTypeTrait;

    case WaitForPublish;
    case PublishBatchMessages;
    case QueueOverloadedForFinalBatch;
}
