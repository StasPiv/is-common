<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use MongoDB\Model\BSONArray;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class GameMessageModel extends AbstractMessageModel implements ModelInCollectionInterface, MessageModelInterface
{
    private string $id;

    private ?string $eventId = null;

    public function __construct(
        private readonly ?string $pgn = null,
        private readonly ?string $pgnHash = null,
        private readonly ?array $varcharData = null,
        private readonly ?array $intData = null,
        private readonly ?array $moves = null,
    ) {
    }

    public function getDataForSerialize(): array
    {
        return [
            'id' => $this->id,
            'pgn' => $this->pgn,
            'pgnHash' => $this->pgnHash,
            'varcharData' => $this->varcharData,
            'intData' => $this->intData,
            'moves' => $this->moves,
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

        if (isset($data['eventId'])) {
            $eventId = $data['eventId'];
            unset($data['eventId']);
        } else {
            $eventId = null;
        }

        if (isset($data['varcharData']) && $data['varcharData'] instanceof BSONArray) {
            $data['varcharData'] = $data['varcharData']->getArrayCopy();
        }

        if (isset($data['intData']) && $data['intData'] instanceof BSONArray) {
            $data['intData'] = $data['intData']->getArrayCopy();
        }

        if (isset($data['moves']) && $data['moves'] instanceof BSONArray) {
            $data['moves'] = $data['moves']->getArrayCopy();
        }

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
