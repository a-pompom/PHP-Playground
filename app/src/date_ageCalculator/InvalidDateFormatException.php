<?php
namespace app\date_ageCalculator;


use Exception;

/**
 * 不正なフォーマットの日付による問題を表現することを責務に持つ
 */
class InvalidDateFormatException extends Exception{}