<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

trait IdAwareTrait
{
    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function hasId(): bool
    {
        return isset($this->id);
    }
}