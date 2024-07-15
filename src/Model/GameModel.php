<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

class GameModel implements ModelInCollectionInterface, StringInterface, MessageModelInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $pgn,
        private readonly string $pgnHash,
    ) {
    }

    public function getCollection(): string
    {
        return 'games';
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'pgn' => $this->pgn,
            'pgn_hash' => $this->pgnHash,
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return json_encode($this->getData());
    }

    public function getPgnHash(): string
    {
        return $this->pgnHash;
    }
}
