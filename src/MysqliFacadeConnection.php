<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common;

use mysqli;
use mysqli_result;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\EventManagerInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\MysqlConnectionInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Enum\ProcessEventTypeEnum;
use StanislavPivovartsev\InterestingStatistics\Common\Model\DataAwareProcessDataModel;
use Throwable;

class MysqliFacadeConnection implements MysqlConnectionInterface
{
    public function __construct(
        private readonly mysqli $mysqli,
        private readonly EventManagerInterface $eventManager,
    ) {
    }

    public function query(string $sql): mysqli_result|bool
    {
        return $this->mysqli->query($sql);
    }

    /**
     * @throws \Throwable
     */
    public function queryForce(string $sql): mysqli_result|bool
    {
        try {
            return $this->mysqli->query($sql);
        } catch (Throwable $exception) {
            $this->eventManager->notify(
                ProcessEventTypeEnum::ModelSaveFailed,
                new DataAwareProcessDataModel(['exception' => $exception->getMessage()]),
            );

            return false;
        }
    }

    public function getAffectedRows(): int
    {
        return $this->mysqli->affected_rows;
    }
}
