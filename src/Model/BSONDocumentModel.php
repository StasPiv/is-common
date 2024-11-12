<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use MongoDB\Model\BSONDocument;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class BSONDocumentModel implements ModelInCollectionInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private readonly BSONDocument $document,
    ) {
    }

    public function getId(): string
    {
        return $this->document->offsetGet('_id');
    }

    public function setId(string $id): void
    {
        $this->document->offsetSet('_id', $id);
    }

    public function hasId(): bool
    {
        return $this->document->offsetExists('_id');
    }

    public function getDataForSave(): array
    {
        return $this->document->getArrayCopy();
    }

    public function getDataForSerialize(): array
    {
        $arrayCopy = $this->document->getArrayCopy();

        if (isset($arrayCopy['_id'])) {
            $arrayCopy['id'] = $arrayCopy['_id'];
            unset($arrayCopy['_id']);
        }

        return $arrayCopy;
    }
}