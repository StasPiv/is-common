<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Exception;

use RuntimeException;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ProcessDataInterface;

class ProcessorException extends RuntimeException implements ProcessDataInterface
{
}