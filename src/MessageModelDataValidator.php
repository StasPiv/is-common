<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelDataValidatorInterface;

class MessageModelDataValidator implements MessageModelDataValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validateData(array $data, string $modelClass): bool
    {
        return array_diff($modelClass::getProperties(), array_keys($data)) === [] &&
            array_diff(array_keys($data), $modelClass::getProperties()) === [];
    }
}
