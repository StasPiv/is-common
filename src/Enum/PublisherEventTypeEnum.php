<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

enum PublisherEventTypeEnum implements EventTypeInterface
{
    use EventTypeTrait;

    case MessageCountGreaterThanLimit;
    case PublishBatchMessages;
}
