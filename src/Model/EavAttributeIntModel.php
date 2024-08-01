<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

class EavAttributeIntModel extends AbstractEavAttributeValueModel
{
    use StringJsonEncodableTrait;

    protected function checkValueType(mixed $value): bool
    {
        return is_numeric($value);
    }
}