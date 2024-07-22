<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;

abstract class AbstractMessageModel implements MessageModelInterface
{
    use StringJsonEncodableTrait;

    public static function getInstance(...$data): static
    {
        return new static(...$data);
    }
}
