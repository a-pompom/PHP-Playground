<?php

namespace app\hello;

const DIVISOR_FIZZ_BUZZ = 15;
const DIVISOR_FIZ = 3;
const DIVISOR_BUZZ = 5;

/**
 * FizzBuzzゲームを表現することを責務に持つ
 */
class FizzBuzz
{
    //
    public function fizzBuzz(int $value): string | int
    {
        if ($value % DIVISOR_FIZZ_BUZZ === 0) {
            return 'FIZZ BUZZ';
        }
        if ($value % DIVISOR_FIZ === 0) {
            return 'FIZZ';
        }
        if ($value % DIVISOR_BUZZ === 0) {
            return 'BUZZ';
        }
        return $value;
    }
}