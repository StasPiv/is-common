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
        private readonly string $user,
    ) {
    }

    public function getDataForSerialize(): array
    {
        return [
            'pgn' => $this->pgn,
        ];
    }

    public function getPgn(): string
    {
        return $this->pgn;
    }

    public function getUser(): string
    {
        return $this->user;
    }
}
