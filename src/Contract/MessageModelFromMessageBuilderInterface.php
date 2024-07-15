<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelFromMessageBuilderInterface
{
    public function buildMessageModelFromMessage(ModelAwareInterface $message): MessageModelInterface;
}