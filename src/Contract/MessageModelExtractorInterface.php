<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelExtractorInterface
{
    public function extractMessageModelFromMessage(ModelAwareInterface $message): MessageModelInterface;
}