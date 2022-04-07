# 概要

日付オブジェクトを色々試してみる。

## ゴール

日付オブジェクトの基本操作を理解することを目指す。


## チートシート

* 任意の日付は`DateTime::__construct()`で引数なし(現在日付)または`yyyy-MM-DD`形式からつくるのがよさそう
* 日付判定は`checkdate()`を利用
* 日付の等価比較はテストコードぐらいでしか必要無いはずなので、UNIXタイムスタンプが妥当か
* 日付の差分をとる`diff()`は引数が基準となっていることに注意が必要

### 日付オブジェクトをつくりたい

PHPでは日付オブジェクトはDateTimeオブジェクトで表現される。

[参考](https://www.php.net/manual/en/datetime.construct.php)

> 書式: `public DateTime::__construct(string $datetime = "now", ?DateTimeZone $timezone = null)`

#### datetime

datetime引数の書式は、指定されたフォーマットに従う。
単に日付を指定するだけであれば、`yyyy-MM-dd`がシンプルか。

[参考](https://www.php.net/manual/en/datetime.formats.php)

#### timezone

DateTimeZoneオブジェクトを指定。未指定の場合はphp.iniに指定されたもの(current timezone)が利用される。
[参考](https://www.php.net/manual/en/class.datetimezone.php)

### 日付かどうか判定したい

色々と方法は考えられるが、`checkdate()`がシンプルか。
[参考](https://www.php.net/manual/en/function.checkdate.php)

> 書式: `checkdate(int $month, int $day, int $year): bool`

日付であるか否かをbool値で返却。
他の手段には`DateTime::createFromFormat()`や`strtotime()`などがある。

### 日付が同じか比較したい

色々と調べてみたが、大小関係の比較しかなかった。
`==`を例にしているものもあったが、さすがに信頼性に欠ける。
公式を見た限りだと、同じ日付か判定したいケース、つまりテストコードの文脈では、UNIXタイムスタンプで比べるのが良さそう。

[参考](https://www.php.net/manual/en/datetime.gettimestamp.php)


### 日付オブジェクトの差をとりたい

[参考](https://www.php.net/manual/en/datetime.diff.php)

> 書式: `public DateTime::diff(DateTimeInterface $targetObject, bool $absolute = false): DateInterval`

diffメソッドは呼び元のDateTimeオブジェクトを基準にしているように見える。
しかし、実際は引数のオブジェクトが基準となっていることに注意が必要。
公式のサンプルを抜粋してみる。

```PHP
<?php
$origin = new DateTime('2009-10-11');
$target = new DateTime('2009-10-13');
$interval = $origin->diff($target);
echo $interval->format('%R%a days');

// +2 days
?>
```

diffメソッドの結果は2日進んでいることを表現している。これは、`$origin`ではなく`$target`が基準となっていたことを表す。
