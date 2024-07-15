<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelDataValidatorInterface;

class MessageModelDataValidator implements MessageModelDataValidatorInterface
{
    /**
     * @inheritDoc
     */
    public function validateData($object, string $modelClass): bool
    {
        return $object instanceof $modelClass;
    }
}
