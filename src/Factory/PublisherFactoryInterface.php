<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Factory;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageBuilderInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\PublisherInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\SubscriberInterface;

interface PublisherFactoryInterface
{
    public function createPublisherMessageBuilder(): MessageBuilderInterface;

    public function createPublisher(): PublisherInterface;

    public function createPublisherEventManager(): EventManagerInterface;

    public function createPublishingSubscriber(): SubscriberInterface;
}