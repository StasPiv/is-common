<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class GameMessageModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    private string $id;

    public function __construct(
        private readonly string $pgn,
        private readonly string $pgnHash,
    ) {
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'pgn' => $this->pgn,
            'pgnHash' => $this->pgnHash,
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getPgnHash(): string
    {
        return $this->pgnHash;
    }

    public function getPgn(): string
    {
        return $this->pgn;
    }
}
