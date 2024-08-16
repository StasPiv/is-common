<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

trait IdentityMapTrait
{
    protected array $identityMap = [];

    protected function getFromIdentityMap(string $identityKey, callable $identityValueFn, array $identityValueFnArgs = []): mixed
    {
        if (isset($this->identityMap[$identityKey])) {
            return $this->identityMap[$identityKey];
        }

        return $this->identityMap[$identityKey] = call_user_func_array($identityValueFn, $identityValueFnArgs);
    }
}