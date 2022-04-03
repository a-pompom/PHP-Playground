<?php

namespace hello;

use app\hello\FizzBuzz;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase
{

    // 3で割り切れるものはFIZZを返却するか
    #[ArrayShape(['9' => "int[]", '18' => "int[]", '99' => "int[]"])]
    public function fizzProvider(): array
    {
        return [
            '9' => [9],
            '18' => [18],
            '99' => [99]
        ];
    }

    // パラメータ化テスト: https://phpunit.readthedocs.io/en/latest/writing-tests-for-phpunit.html#writing-tests-for-phpunit-data-providers

    /**
     * @dataProvider fizzProvider
     * @param int $value 関数の入力となる数値
     */
    public function testFizz(int $value)
    {
        // GIVEN
        $expected = 'FIZZ';
        $sut = new FizzBuzz();
        // WHEN
        $actual = $sut->fizzBuzz($value);
        // THEN
        $this->assertSame($expected, $actual);
    }

    // 5で割り切れるものはBUZZを返すか
    #[ArrayShape(['5' => "int[]", '10' => "int[]", '50' => "int[]"])]
    public function buzzProvider(): array
    {
        return [
            '5' => [5],
            '10' => [10],
            '50' => [50]
        ];
    }

    /**
     * @dataProvider buzzProvider
     * @param int $value 関数の入力となる数値
     */
    public function testBuzz(int $value)
    {
        // GIVEN
        $expected = 'BUZZ';
        $sut = new FizzBuzz();
        // WHEN
        $actual = $sut->fizzBuzz($value);
        // THEN
        $this->assertSame($expected, $actual);
    }

    // 15で割り切れるものはFIZZ BUZZを返すか
    #[ArrayShape(['15' => "int[]", '45' => "int[]", '105' => "int[]"])]
    public function fizzBuzzProvider(): array
    {
        return [
            '15' => [15],
            '45' => [45],
            '105' => [105],
        ];
    }

    /**
     * @dataProvider fizzBuzzProvider
     * @param int $value 関数の入力となる数値
     */
    public function testFizzBuzz(int $value)
    {
        // GIVEN
        $expected = 'FIZZ BUZZ';
        $sut = new FizzBuzz();
        // WHEN
        $actual = $sut->fizzBuzz($value);
        // THEN
        $this->assertSame($expected, $actual);
    }

    // FIZZ BUZZの対象とならない数値はそのままの値が返却されるか
    #[ArrayShape(['1' => "int[]", '98' => "int[]"])]
    public function noneProvider(): array
    {
        return [
            '1' => [1],
            '98' => [98]
        ];
    }

    /**
     * @dataProvider noneProvider
     * @param int $value 関数の入力となる数値
     */
    public function testNone(int $value)
    {
        // GIVEN
        $expected = $value;
        $sut = new FizzBuzz();
        // WHEN
        $actual = $sut->fizzBuzz($value);
        // THEN
        $this->assertSame($expected, $actual);
    }
}
