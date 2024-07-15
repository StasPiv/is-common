<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Exception\MessageModelBuilderException;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelAwareInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;

class MessageModelFromMessageBuilder implements MessageModelFromMessageBuilderInterface
{
    public function __construct(
        private readonly MessageModelFromStringBuilderInterface $messageModelFromStringBuilder,
    ) {
    }

    public function buildMessageModelFromMessage(ModelAwareInterface $message): MessageModelInterface
    {
        /** @var class-string|\StanislavPivovartsev\InterestingStatistics\Common\Model\AbstractMessageModel $modelClass */
        $modelClass = $message->getModelInstance();

        $modelInstance = $this->messageModelFromStringBuilder->buildMessageModelFromString((string) $message, $modelClass);

        if (!$modelInstance instanceof MessageModelInterface) {
            throw new MessageModelBuilderException('Can not build model ' . get_class($modelInstance) .' from message');
        }

        return $modelInstance;
    }
}