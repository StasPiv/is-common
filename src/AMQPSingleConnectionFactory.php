<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;

class AMQPSingleConnectionFactory extends AMQPConnectionFactory
{
    use IdentityMapTrait;

    public function createAMQPChannel(): AMQPChannel
    {
        return $this->getFromIdentityMap(
            'channel',
            fn (): AMQPChannel => parent::createAMQPChannel(),
            func_get_args()
        );
    }
}