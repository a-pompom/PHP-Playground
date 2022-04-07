<?php
namespace tests\date_ageCalculator;

use app\date_ageCalculator\DateTimeConverter;
use app\date_ageCalculator\InvalidDateFormatException;

use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

class DateTimeConverterTest extends TestCase
{

    // 日付表現の文字列を日付オブジェクトへ変換できるか
    #[ArrayShape(['first day' => "array", 'the last day' => "array", 'leap year' => "array"])]
    public function dateTimeProvider(): array
    {
        return [
            'first day' => ['2020', '1', '1', new DateTime('2020-01-01')],
            'the last day' => ['2000', '12', '31', new DateTime('2000-12-31')],
            'leap year' => ['2020', '2', '29', new DateTime('2020-02-29')],
        ];
    }

    /**
     * @dataProvider dateTimeProvider
     *
     * @param string $year 年
     * @param string $month 月
     * @param string $day 日
     * @param DateTime $expected 期待値
     */
    public function testConvertDateTime(string $year, string $month, string $day, DateTime $expected)
    {
        // GIVEN
        $sut = new DateTimeConverter();
        // WHEN
        try {
            $actual = $sut->convert($year, $month, $day)->getTimestamp();
        } catch (InvalidDateFormatException) {
            $this->fail('入力された日付が不正です。');
        }

        // THEN
        // 今回の日付オブジェクトは表現が固定されていることから、UNIXタイムスタンプで等価比較
        $this->assertSame($actual, $expected->getTimestamp());
    }

    // 不正な日付が入力で与えられると例外を送出するか
    public function invalidDateTimeProvider(): array
    {
        return [
            'over year' => ['999999', '12', '31'],
            'over month' => ['2000', '14', '10'],
            'over day' => ['2000', '2', '31'],
            'not a number' => ['二千二十年', '一月', '一日']
        ];
    }

    /**
     * @dataProvider invalidDateTimeProvider
     *
     * @param string $year 年
     * @param string $month 月
     * @param string $day 日
     * @throws InvalidDateFormatException 不正な日付で送出される例外
     */
    public function testConvertInvalidDateTime(string $year, string $month, string $day)
    {
        // GIVEN
        $sut = new DateTimeConverter();
        // WHEN
        $this->expectException(InvalidDateFormatException::class);
        $sut->convert($year, $month, $day);
    }
}
