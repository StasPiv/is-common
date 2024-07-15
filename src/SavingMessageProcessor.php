<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionFinderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSavableModelBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\CollectionSaverInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageProcessorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataBuilderInterface;
use Throwable;

class SavingMessageProcessor implements MessageProcessorInterface
{
    public function __construct(
        private readonly CollectionSaverInterface               $collectionSaver,
        private readonly CollectionSavableModelBuilderInterface $collectionSavableModelBuilder,
        private readonly CollectionFinderInterface $collectionFinder,
        private readonly ProcessDataBuilderInterface $processDataBuilder,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function process(MessageInterface $message): void
    {
        try {
            $savableModel = $this->collectionSavableModelBuilder->buildCollectionSavableModel($message);

            if ($this->collectionFinder->modelExists($savableModel)) {
                $alreadyFound = $this->processDataBuilder->buildSuccessfulProcessData(
                    $message,
                    $savableModel,
                    'Model already found'
                );

                $this->eventManager->notify($alreadyFound);

                return;
            }

            $this->collectionSaver->saveModel($savableModel);
        } catch (Throwable $exception) {
            $failedProcessData = $this->processDataBuilder->buildFailedProcessData($message, $exception->getMessage());

            $this->eventManager->notify($failedProcessData);

            return;
        }

        $successfullySaved = $this->processDataBuilder->buildSuccessfulProcessData(
            $message,
            $savableModel,
            'Model successfully saved'
        );

        $this->eventManager->notify($successfullySaved);
    }
}
