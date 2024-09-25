<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\QueueDeclareProcessorInterface;

class MessageCountQueueDeclareProcessorFactory implements Contract\QueueDeclareProcessorFactoryInterface
{
    public function createQueueDeclareProcessor(): QueueDeclareProcessorInterface
    {
        return new MessageCountQueueDeclareProcessor();
    }
}