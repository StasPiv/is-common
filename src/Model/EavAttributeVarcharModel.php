<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

class EavAttributeVarcharModel extends AbstractEavAttributeValueModel
{
    use StringSerializableTrait;

    protected function checkValueType(mixed $value): bool
    {
        return is_string($value);
    }
}