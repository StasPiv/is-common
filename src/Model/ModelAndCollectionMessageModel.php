<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;

class ModelAndCollectionMessageModel implements MessageModelInterface
{
    use StringJsonEncodableTrait;

    public function __construct(
        private readonly string $collection,
        private readonly ModelInCollectionInterface $model,
    ) {
    }

    protected function getData(): array
    {
        return [
            'collection' => $this->collection,
            'model' => $this->model,
        ];
    }
}