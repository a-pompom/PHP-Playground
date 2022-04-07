<?php
namespace app\date_ageCalculator;
require_once '../../vendor/autoload.php';

// 誕生日
$birthYear = $_POST['birthYear'] ?? '';
$birthMonth = $_POST['birthMonth'] ?? '';
$birthDay = $_POST['birthMonth'] ?? '';

// 基準日
$currentYear = $_POST['currentYear'] ?? '';
$currentMonth = $_POST['currentMonth'] ?? '';
$currentDay = $_POST['currentMonth'] ?? '';

// 日付形式へ
$converter = new DateTimeConverter();
try {
    $birthDate = $converter->convert($birthYear, $birthMonth, $birthDay);
    $currentDate = $converter->convert($currentYear, $currentMonth, $currentDay);
} catch (InvalidDateFormatException $e) {
    // 今回は日付オブジェクトに集中したいので単に元のページに戻す程度に留める
    header('Location: ./form.html', true, 301);
    exit;
}

// 年齢計算
$ageCalculator = new AgeCalculator();
if (! $ageCalculator->isBirthDateLessThanOrEqualToCurrentDate($birthDate, $currentDate)) {
    header('Location: ./form.html', true, 301);
    exit;
}

$age = $ageCalculator->calculateAge($birthDate, $currentDate);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Result</title>
</head>
<body>
<div>
    <h2>年齢は<?=$age?>歳です。</h2>
</div>
</body>
</html>