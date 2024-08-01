<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Model;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class ModelAndCollectionMessageModel extends AbstractMessageModel implements ProcessDataInterface
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
            'model' => $this->model->getData(),
        ];
    }
}