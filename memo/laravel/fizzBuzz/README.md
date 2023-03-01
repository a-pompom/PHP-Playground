# ゴール

FizzBuzzアプリケーションを題材にテンプレートの簡単な使い方を知る。

## テンプレートを利用した画面表示

Laravelでは、Bladeと呼ばれるテンプレートエンジンでViewを組み立てるようだ。
テンプレートはresources/viewディレクトリ以下へ置かれる。

まずは単なるHTMLをテンプレートとしてつくってみる。
[参考](https://laravel.com/docs/10.x/blade)

```html
<!-- fizzBuzz.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FizzBuzz</title>
</head>
<h1>FizzBuzz</h1>
</html>
```

### ControllerからViewを組み立て

[参考](https://laravel.com/docs/10.x/views#creating-and-rendering-views)

```php
<?php
// FizzBuzzController.php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FizzBuzzController extends Controller
{
    public function view(): View
    {
        return view('fizzBuzz');
    }
}
```

view関数は第一引数にテンプレートファイルのパスを記述。パスはresources/viewsを起点とする。

`http://localhost:8000/fizzBuzz`へアクセスすると、テンプレートをもとにHTMLが描画される。

### 指定回数FizzBuzzメッセージを表示

viewを組み立てる処理には、連想配列形式でデータを渡すことができる。

```php
// FizzBuzzController
public function view(): View
{
    $context = [
        'count' => 15
    ];
    return view('fizzBuzz', $context);
}
```

#### テンプレート

Bladeテンプレートでは、ディレクティブと呼ばれる構文でPHPと対応する制御構文やレイアウト・コンポーネントなどの機能を表現できる。 

[参考](https://laravel.com/docs/10.x/blade)

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FizzBuzz</title>
</head>
<h1>FizzBuzz</h1>

@for($i=1; $i<=$count;$i++)
    @if($i % 15 === 0)
        <p>FizzBuzz!!</p>
    @elseif($i % 3 === 0)
        <p>Fizz</p>
    @elseif($i % 5 === 0)
        <p>Buzz</p>
    @else
        <p>{{$i}}</p>
    @endif
@endfor
</html>
```

再度サーバを起動すると、FizzBuzzメッセージがHTML形式で表示される