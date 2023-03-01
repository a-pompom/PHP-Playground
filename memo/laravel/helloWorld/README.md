# ゴール

Laravelプロジェクトをつくり、Hello World画面を表示。
Laravelアプリケーションをつくるときの大まかな流れを理解することを目標に。

## プロジェクト構築

※ composerが利用できる環境を前提とする。

```bash
composer create-project laravel/laravel sample
```

GitHubの`laravel/laravel`リポジトリをクローンし、`composer install`を実行。
これにより、Laravelアプリケーションの雛形・依存ライブラリが出来上がる。

### サーバ起動

artisanがコマンドのエントリポイント。
Laravelは開発用のサーバを用意しているので、`php artisan serve`コマンドでサーバが起動。

```bash
php artisan serve --host 0.0.0.0

INFO  Server running on [http://0.0.0.0:8000].  
```

Laravelのロゴが表示されていれば成功。

### 文字列Hello Worldを表示するController

Laravelは各種モジュールをテンプレートから構築するためのコマンドを用意している。
色々と種類があるので、暗記するのではなく`php artisan list`コマンドから必要なものを探せるようにしておく。

今回はControllerをつくりたいので、`php artisan make:controller`を実行。

```bash
$ php artisan list make | grep 'controller'
  make:controller    Create a new controller class
```

すると、app/Http/ControllersへControllerクラスがつくられる。

```php
// HelloController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
}
```

雛形へメソッドを追加し、HTTPレスポンスを返せるようにしてみる。

リクエストを受け取ってレスポンスが返されるまでの流れは、[参考リンク](https://laravel.com/docs/10.x/lifecycle)参照。

```php
// HelloController.php
class HelloController extends Controller
{
    /**
     * 文字列でHTTPレスポンスを返却
     * @return string メッセージ
     */
    public function hello(): string
    {
        return "Hello Laravel";
    }
}
```

`Route::get()`は第一引数にURL・第二引数にactionを受け取る。
actionは内部で`Controllerの完全修飾クラス名を表現する文字列@メソッド名`の形式で扱われる。
ただし、これは補完の恩恵を受けづらいので、配列形式でクラス名・メソッド名をそれぞれ渡す方法が主流のようだ。
※ 配列形式は内部で上の文字列の形式へ変換される。

```php
// routes/web.php
// ルーティング設定 URLとコントローラのメソッドを対応づけ
Route::get('/hello', [\App\Http\Controllers\HelloController::class, 'hello']);
```

#### 動作確認

これでURLとController・メソッドが対応づけられたので、実際に確認してみる。

```bash
# サーバ起動
$ php artisan serve --host 0.0.0.0
```

`http://localhost:8000/hello`へアクセスすると、文字列が画面へ表示されたことを確認。
