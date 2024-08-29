<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Tests\ScoreDiffCalculator;

use Iterator;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;

class ScoreDiffCalculatorDataProvider
{
    public static function provideDataForCalculateDiff(): Iterator
    {
        yield 'losing move' => [
            'scoreBefore' => 300,
            'scoreAfter' => -300,
            'expectedDiff' => -600,
        ];

        yield 'missing win' => [
            'scoreBefore' => 500,
            'scoreAfter' => 0,
            'expectedDiff' => -300,
        ];

        yield 'missing draw' => [
            'scoreBefore' => 0,
            'scoreAfter' => -600,
            'expectedDiff' => -300,
        ];

        yield 'anyway lose' => [
            'scoreBefore' => -300,
            'scoreAfter' => -600,
            'expectedDiff' => 0,
        ];

        yield 'anyway win' => [
            'scoreBefore' => 600,
            'scoreAfter' => 300,
            'expectedDiff' => 0,
        ];
    }

    public static function provideDataForCalculateAccuracy(): Iterator
    {
        yield 'losing move' => [
            'scoreBefore' => 300,
            'scoreAfter' => -300,
            'expectedDiff' => 0.0,
        ];

        yield 'missing win' => [
            'scoreBefore' => 500,
            'scoreAfter' => 0,
            'expectedDiff' => 50.0,
        ];

        yield 'missing draw' => [
            'scoreBefore' => 0,
            'scoreAfter' => -600,
            'expectedDiff' => 50.0,
        ];

        yield 'anyway lose' => [
            'scoreBefore' => -300,
            'scoreAfter' => -600,
            'expectedDiff' => 100.0,
        ];

        yield 'anyway win' => [
            'scoreBefore' => 600,
            'scoreAfter' => 300,
            'expectedDiff' => 100.0,
        ];

        yield 'slightly worse' => [
            'scoreBefore' => 140,
            'scoreAfter' => 125,
            'expectedDiff' => 94.64285714285715,
        ];
    }
}