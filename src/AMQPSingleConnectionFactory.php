<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;

class AMQPSingleConnectionFactory extends AMQPConnectionFactory
{
    use IdentityMapTrait;

    public function createAMQPChannel(): AMQPChannel
    {
        return $this->getFromIdentityMap(__FUNCTION__, func_get_args());
    }
}