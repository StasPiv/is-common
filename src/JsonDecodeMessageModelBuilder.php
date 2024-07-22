<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\MessageModelBuilderException;

class JsonDecodeMessageModelBuilder implements MessageModelFromStringBuilderInterface
{
    /**
     * @inheritDoc
     */
    public function buildMessageModelFromString(string $string, string $modelClass): MessageModelInterface
    {
        $data = json_decode($string, true);

        $object = $modelClass::getInstance(...$data);

        if (!$object instanceof $modelClass) {
            throw new MessageModelBuilderException(
                "Incorrect data $string in message for model: " . $modelClass
            );
        }

        return $object;
    }
}