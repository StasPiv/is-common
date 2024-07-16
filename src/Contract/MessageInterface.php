<?php

declare(strict_types = 1);

namespace StanislavPivovartsev\InterestingStatistics\Common\Contract;

interface MessageInterface extends AckableInterface, ModelAwareInterface, ProcessDataInterface
{

}