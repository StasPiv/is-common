<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

enum PublisherEventTypeEnum implements EventTypeInterface
{
    use EventTypeTrait;

    case WaitForPublish;
    case Publish;
    case PublishBatchMessages;
    case PublishFail;
    case QueueOverloadedForFinalBatch;
    case NackReceived;
}
