<?php

namespace StanislavPivovartsev\InterestingStatistics\Common;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\Configuration\AMQPConnectionConfigurationInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\StringInterface;

class ChessMqPublisher implements Contract\PublisherInterface
{
    public function __construct(
        private readonly AMQPConnectionConfigurationInterface $amqpConnectionConfiguration,
        private readonly string                $queue,
    ) {
    }

    public function publish(StringInterface $model): void
    {
        $fp = fsockopen(
            $this->amqpConnectionConfiguration->getHost(),
            $this->amqpConnectionConfiguration->getPort(),
            $errno,
            $errstr,
            30
        );
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $out = 'publish to ' . $this->queue . ' message ' . $model;
            echo $out . PHP_EOL;
            fwrite($fp, $out . PHP_EOL);
            while (!feof($fp)) {
                echo fgets($fp, 1024) . PHP_EOL;
            }
            fclose($fp);
        }
    }

    public function publishBatch(): void
    {
        // TODO: Implement publishBatch() method.
    }
}