<?php

namespace StanislavPivovartsev\InterestingStatistics\Common\Tests\ScoreDiffCalculator;

use PHPUnit\Framework\TestCase;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveMessageModel;
use StanislavPivovartsev\InterestingStatistics\Common\Model\MoveScoreModel;
use StanislavPivovartsev\InterestingStatistics\Common\ScoreDiffCalculator;

class ScoreDiffCalculatorTest extends TestCase
{
    /**
     * @dataProvider \StanislavPivovartsev\InterestingStatistics\Common\Tests\ScoreDiffCalculator\ScoreDiffCalculatorDataProvider::provideDataForCalculateDiff
     *
     * @return void
     */
    public function testCalculateDiff(int $scoreBefore, int $scoreAfter, int $expectedDiff): void
    {
        // arrange
        $calculator = new ScoreDiffCalculator();
        $moveScoreModel = new MoveScoreModel($this->createMock(MoveMessageModel::class), $scoreBefore, $scoreAfter, null, null);

        // act
        $actualDiff = $calculator->calculateDiff($moveScoreModel);

        // assert
        self::assertSame($expectedDiff, $actualDiff);
    }

    /**
     * @dataProvider \StanislavPivovartsev\InterestingStatistics\Common\Tests\ScoreDiffCalculator\ScoreDiffCalculatorDataProvider::provideDataForCalculateAccuracy
     */
    public function testCalculateAccuracy(int $scoreBefore, int $scoreAfter, float $expectedAccuracy): void
    {
        // arrange
        $calculator = new ScoreDiffCalculator();
        $moveScoreModel = new MoveScoreModel($this->createMock(MoveMessageModel::class), $scoreBefore, $scoreAfter, null, null);

        // act
        $actualDiff = $calculator->calculateAccuracy($moveScoreModel);

        // assert
        self::assertSame($expectedAccuracy, $actualDiff);
    }
}