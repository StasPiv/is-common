<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageModelFromProcessDataBuilderInterface
{
    public function buildMessageModelFromProcessData(SuccessfulProcessDataInterface $data): MessageModelInterface;
}
