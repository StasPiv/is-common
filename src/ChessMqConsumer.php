<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConsumerConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPMessageFacadeConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ConsumerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MessageReceiverInterface;

class ChessMqConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly AMQPConnectionConfigurationInterface $connectionConfiguration,
        private readonly AMQPConsumerConfigurationInterface $consumerConfiguration,
        private readonly MessageReceiverInterface $messageReceiver,
        private readonly AMQPMessageFacadeConfigurationInterface $configuration,
    ) {
    }

    public function consume(): void
    {
        $fp = $this->openSocket();

        while (!feof($fp)) {
            $response = fgets($fp, 1024);
            if (strlen(trim($response)) !== 0) {
                $this->messageReceiver->onReceive(new ChessMqMessageFacade($response, $this->configuration->getModelInstance()));

                $fp = $this->openSocket();
            }
        }
    }

    private function openSocket()
    {
        $fp = fsockopen(
            $this->connectionConfiguration->getHost(),
            $this->connectionConfiguration->getPort(),
            $errno,
            $errstr,
            -1
        );

        $out = 'subscribe on ' . $this->consumerConfiguration->getQueue();
        fwrite($fp, $out . PHP_EOL);

        return $fp;
    }
}