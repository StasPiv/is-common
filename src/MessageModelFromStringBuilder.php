<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelDataValidatorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\MessageModelBuilderException;

class MessageModelFromStringBuilder implements MessageModelFromStringBuilderInterface
{
    public function __construct(
        private readonly MessageModelDataValidatorInterface $messageModelDataValidator,
    ) {
    }

    /**
     * @param class-string|\StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractMessageModel $modelClass
     *
     * @throws \JsonException
     */
    public function buildMessageModelFromString(string $string, string $modelClass): MessageModelInterface
    {
        $data = unserialize($string);

        if (!$this->messageModelDataValidator->validateData($data, $modelClass)) {
            throw new MessageModelBuilderException(
                "Incorrect data $string in message for model: " . $modelClass
            );
        }

        $arguments = array_map(fn (string $key) => $data[$key], $modelClass::getProperties());

        return new $modelClass(...$arguments);
    }
}