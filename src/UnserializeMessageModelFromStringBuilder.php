<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\MessageModelBuilderException;

class UnserializeMessageModelFromStringBuilder implements MessageModelFromStringBuilderInterface
{
    /**
     * @param class-string|\StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractMessageModel $modelClass
     *
     * @throws \JsonException
     */
    public function buildMessageModelFromString(string $string, string $modelClass): MessageModelInterface
    {
        $object = unserialize($string);

        if (!$object instanceof $modelClass) {
            throw new MessageModelBuilderException(
                "Incorrect data $string in message for model: " . $modelClass
            );
        }

        return $object;
    }
}