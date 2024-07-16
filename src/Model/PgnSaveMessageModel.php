<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Model\PgnAwareModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class PgnSaveMessageModel extends AbstractMessageModel implements
    MessageModelInterface,
    PgnAwareModelInterface,
    ProcessDataInterface
{
    public function __construct(
        protected string $pgn,
    ) {
    }

    public function getPgn(): string
    {
        return $this->pgn;
    }

    public function toArray(): array
    {
        return [
            'pgn' => $this->getPgn(),
        ];
    }

    public static function getProperties(): array
    {
        return ['pgn'];
    }

    public function getData(): array
    {
        return $this->toArray();
    }
}
