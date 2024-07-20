<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface CollectionFinderInterface extends CollectionInterface
{
    /**
     * @param array<string, string> $criteria
     */
    public function modelExists(array $criteria): bool;

    /**
     * @param \StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface $collection *
     *
     * @return \StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelInCollectionInterface|null
     */
    public function find(string $id): ?ModelInCollectionInterface;

    public function findOneBy(array $criteria): ?ModelInCollectionInterface;
}