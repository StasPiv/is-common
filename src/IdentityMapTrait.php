<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use PhpAmqpLib\Channel\AMQPChannel;

trait IdentityMapTrait
{
    protected array $identityMap = [];

    protected function getFromIdentityMap(string $identityKey, array $identityValueFnArgs = []): mixed
    {
        if (isset($this->identityMap[$identityKey])) {
            return $this->identityMap[$identityKey];
        }

        return $this->identityMap[$identityKey] = call_user_func_array(
            fn (): mixed => parent::{$identityKey}(),
            $identityValueFnArgs,
        );
    }
}