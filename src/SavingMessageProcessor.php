<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSavableModelBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;
use Throwable;

class SavingMessageProcessor implements MessageProcessorInterface
{
    public function __construct(
        private readonly CollectionSaverInterface               $collectionSaver,
        private readonly CollectionSavableModelBuilderInterface $collectionSavableModelBuilder,
        private readonly CollectionFinderInterface $collectionFinder,
        private readonly ProcessDataBuilderInterface $processDataBuilder,
    ) {
    }

    public function process(MessageInterface $message): ProcessDataInterface
    {
        try {
            $savableModel = $this->collectionSavableModelBuilder->buildCollectionSavableModel($message);

            if ($this->collectionFinder->modelExists($savableModel)) {
                return $this->processDataBuilder->buildSuccessfulProcessData(
                    $message,
                    $savableModel,
                    'Model already found'
                );
            }

            $this->collectionSaver->saveModel($savableModel);
        } catch (Throwable $exception) {
            return $this->processDataBuilder->buildFailedProcessData($message, $exception->getMessage());
        }

        return $this->processDataBuilder->buildSuccessfulProcessData(
            $message,
            $savableModel,
            'Model successfully saved'
        );
    }
}
