<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

class PlayerModel extends AbstractMessageModel implements StringInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private readonly string $name,
        private readonly int $elo,
    ) {
    }

    public function toArray(): array
    {
        return $this->getData();
    }

    protected function getData(): array
    {
        return [
            'name' => $this->name,
            'elo' => $this->elo,
        ];
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