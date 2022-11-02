<?php
namespace app\date_ageCalculator;

use DateTime;

/**
 * 基準日・誕生日をもとに年齢を算出することを責務に持つ
 */
class AgeCalculator
{

    /**
     * 誕生日が基準日より前か、すなわち年齢を算出する対象として妥当か判定
     *
     * @param DateTime $birthDate 誕生日
     * @param DateTime $currentDate 基準日
     * @return bool 誕生日が基準日よりも過去->true, 未来->false
     */
    public function isBirthDateLessThanOrEqualToCurrentDate(DateTime $birthDate, DateTime $currentDate): bool
    {
        return $birthDate <= $currentDate;
    }

    /**
     * 年齢を算出
     *
     * @param DateTime $birthDate 生年月日
     * @param DateTime $currentDate 基準日
     * @return int 年齢
     */
    public function calculateAge(DateTime $birthDate, DateTime $currentDate): int
    {
        return $birthDate->diff($currentDate, false)->y;
    }
}