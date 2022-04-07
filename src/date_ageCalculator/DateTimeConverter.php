<?php

namespace app\date_ageCalculator;

use DateTime;

/**
 * 入力値を日付オブジェクトへ変換することを責務に持つ
 */
class DateTimeConverter
{
    /**
     * 入力値の文字列の日付から日付オブジェクトへ変換
     *
     * @param string $year 年
     * @param string $month 月
     * @param string $day 日
     * @return DateTime 日付オブジェクト
     * @throws InvalidDateFormatException 不正な日付で送出される例外
     */
    public function convert(string $year, string $month, string $day): DateTime
    {
        if (!$this->isValid($year, $month, $day)) {
            throw new InvalidDateFormatException();
        }

        $dateFormatString = "${year}-${month}-${day}";
        try {
            return new DateTime($dateFormatString);
        } catch (\Exception $e) {
            throw new InvalidDateFormatException();
        }
    }

    /**
     * 入力の日付が日付表現として妥当か判定
     *
     * @param string $year 年
     * @param string $month 月
     * @param string $day 日
     * @return bool 妥当->true, 不正->false
     */
    private function isValid(string $year, string $month, string $day): bool
    {
        // 入力が数値でない
        if (!is_numeric($year) || !is_numeric($month) || !is_numeric($day)) {
            return false;
        }

        // 入力が日付として不正
        if (!checkdate((int)$month, (int)$day, (int)$year)) {
            return false;
        }
        return true;
    }
}
