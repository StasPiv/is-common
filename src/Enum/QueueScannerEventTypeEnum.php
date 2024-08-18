<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Enum;

enum QueueScannerEventTypeEnum implements EventTypeInterface
{
    use EventTypeTrait;

    case WaitForMessages;
}
