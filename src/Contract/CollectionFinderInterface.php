<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFinderInterface extends CollectionInterface
{
    public function findUnique(ModelInCollectionInterface $model, array $options = []): ?ModelInCollectionInterface;

    /**
     * @param \StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface $collection *
     * @param array $options
     *
     * @return \StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface|null
     */
    public function find(string $id, array $options = []): ?ModelInCollectionInterface;

    public function findOneBy(array $criteria, array $options = []): ?ModelInCollectionInterface;

    /**
     * @param array $options *
     *
     * @return array<\StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface>
     */
    public function findAll(array $criteria, array $options = []): array;
}