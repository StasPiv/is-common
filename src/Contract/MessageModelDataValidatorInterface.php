<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelDataValidatorInterface
{
    /**
     * @param class-string|\StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractMessageModel $modelClass
     */
    public function validateData(array $data, string $modelClass): bool;
}
