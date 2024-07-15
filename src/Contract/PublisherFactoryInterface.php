<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelDataValidatorInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromMessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageModelFromStringBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

interface PublisherFactoryInterface
{
    public function createPublisherMessageBuilder(): MessageBuilderInterface;

    public function createPublisher(): PublisherInterface;

    public function createPublisherEventManager(): EventManagerInterface;

    public function createPublishingSubscriber(): SubscriberInterface;

    public function createMessageModelFromMessageBuilder(): MessageModelFromMessageBuilderInterface;

    public function createMessageModelFromStringBuilder(): MessageModelFromStringBuilderInterface;

    public function createMessageModelDataValidator(): MessageModelDataValidatorInterface;
}