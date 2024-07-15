<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

use StanislavPivovartsev\InterestingStatistics\Common\Contract\AckableInterface;
use StanislavPivovartsev\InterestingStatistics\Common\Contract\ModelAwareInterface;

interface MessageInterface extends AckableInterface, ModelAwareInterface
{

}