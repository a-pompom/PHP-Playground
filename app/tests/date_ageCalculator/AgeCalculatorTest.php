<?php
namespace tests\date_ageCalculator;

use app\date_ageCalculator\AgeCalculator;
use PHPUnit\Framework\TestCase;
use \DateTime;

class AgeCalculatorTest extends TestCase
{
    // 誕生日は基準日以前か
    public function isBirthDateLessThanOrEqualToCurrentDateProvider(): array
    {
        return [
            'less than' => [new DateTime('2000-01-01'), new DateTime('2020-01-01'), true],
            'equal' => [new DateTime('2020-01-01'), new DateTime('2020-01-01'), true],
            'greater than' => [new DateTime('2020-01-01'), new DateTime('2000-01-01'), false],
        ];
    }

    /**
     * @dataProvider isBirthDateLessThanOrEqualToCurrentDateProvider
     *
     * @param DateTime $birthDate 誕生日
     * @param DateTime $currentDate 基準日
     * @param bool $expected 期待値
     */
    public function testIsBirthDateLessThanOrEqualToCurrentDate(DateTime $birthDate, DateTime $currentDate, bool $expected)
    {
        // GIVEN
        $sut = new AgeCalculator();
        // WHEN
        $actual = $sut->isBirthDateLessThanOrEqualToCurrentDate($birthDate, $currentDate);
        // THEN
        $this->assertSame($expected, $actual);
    }

    // 誕生日・基準日から年齢を算出できるか
    public function calculateAgeProvider(): array
    {
        return [
            'age zero' => [new DateTime('2022-01-01'), new DateTime('2022-04-01'), 0],
            'age positive' => [new DateTime('2000-01-01'), new DateTime('2020-01-01'), 20],
        ];
    }

    /**
     * @dataProvider calculateAgeProvider
     *
     * @param DateTime $birthDate 誕生日
     * @param DateTime $currentDate 基準日付
     * @param int $expected 期待値
     */
    public function testCalculateAge(DateTime $birthDate, DateTime $currentDate, int $expected)
    {
        // GIVEN
        $sut = new AgeCalculator();
        // WHEN
        $actual = $sut->calculateAge($birthDate, $currentDate);
        // THEN
        $this->assertSame($expected, $actual);
    }
}