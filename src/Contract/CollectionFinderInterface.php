<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFinderInterface extends CollectionInterface
{
    public function findUnique(ModelInCollectionInterface $model): ?ModelInCollectionInterface;

    /**
     * @param \StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface $collection *
     *
     * @return \StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface|null
     */
    public function find(string $id): ?ModelInCollectionInterface;

    public function findOneBy(array $criteria): ?ModelInCollectionInterface;

    /**
     * @param array $options *
     *
     * @return array<\StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface>
     */
    public function findAll(array $criteria, array $options = []): array;
}