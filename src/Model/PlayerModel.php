<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

class PlayerModel extends AbstractMessageModel
{
    public function __construct(
        private readonly string $name,
        private readonly int $elo,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'elo' => $this->elo,
        ];
    }

    public static function getProperties(): array
    {
        return ['name', 'elo'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getElo(): int
    {
        return $this->elo;
    }
}