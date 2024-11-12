<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class GameMessageModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    private string $id;

    private ?string $eventId = null;

    public function __construct(
        private readonly ?string $pgn = null,
        private readonly ?string $pgnHash = null,
    ) {
    }

    public function getDataForSerialize(): array
    {
        return [
            'id' => $this->id,
            'pgn' => $this->pgn,
            'pgnHash' => $this->pgnHash,
        ];
    }

    public function getDataForSave(): array
    {
        return [
            'id' => $this->id,
            'pgn' => $this->pgn,
            'pgnHash' => $this->pgnHash,
            'eventId' => $this->eventId,
        ];
    }

    public static function getInstance(...$data): static
    {
        $id = $data['id'];
        unset($data['id']);
        $eventId = $data['eventId'];
        unset($data['eventId']);

        $gameMessageModel = parent::getInstance(...$data);

        $gameMessageModel->setId($id);
        $gameMessageModel->setEventId($eventId);

        return $gameMessageModel;
    }

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

    public function getPgnHash(): ?string
    {
        return $this->pgnHash;
    }

    public function getPgn(): ?string
    {
        return $this->pgn;
    }

    public function getEventId(): ?string
    {
        return $this->eventId;
    }

    public function setEventId(?string $eventId): GameMessageModel
    {
        $this->eventId = $eventId;

        return $this;
    }
}
