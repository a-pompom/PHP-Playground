# ゴール

ユーザ登録機能をつくりたい。
formの入力を受け取り、妥当性を検証する機能をつくるときの流れを理解したい。
あわせて、データベースのマイグレーションやレコード操作の基本をおさえたい。

## 機能イメージ

* ユーザ登録画面・結果画面の2つを用意
* ユーザ登録画面はユーザ名のみ入力 ボタンで画面遷移
* ユーザ名が空だった場合はエラーメッセージを表示
* 登録に成功した場合、DBへレコードを登録し、フラッシュへユーザIDを設定して結果画面へリダイレクト
* 結果画面ではユーザIDからレコードを読みだし、画面へユーザ名を表示

## DB設定

ユーザ情報を保存するテーブルをつくりたい。
まずは接続設定を編集。今回はMariaDBを利用。

[参考](https://laravel.com/docs/10.x/database)

### Model作成

ユーザ情報を表現するModelをつくりたい。
Modelクラスは`php artisan make:model <モデル名>`で作成。

```bash
$ php artisan make:model SampleUser
```

app/ModelsディレクトリへModelクラスがつくられる。
Modelクラスには、検索・更新処理など、テーブルを操作するメソッドを定義するのが主流のようだ。

```php
// app/Models/SampleUser.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleUser extends Model
{
    use HasFactory;
}
```

### Migration

[参考](https://laravel.com/docs/10.x/migrations)

DjangoのようにModelから自動的にMigrationファイルを組み立てるのではなく、DBに対する操作をMigrationファイルへ直接書き加えていくようだ。

```bash
$ php artisan make:migration craete_sample_users_table

   INFO  Migration [database/migrations/2023_02_22_022636_craete_sample_users_table.php] created successfully.  
```

```php
// database/migrations/create_sample_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
```

### Migrationファイル

Migrationファイルでは、テーブルを操作する命令をSchema Facade・Blueprintオブジェクトを利用して組み立てる。
今回のサンプルでは、単にユーザ情報を表現するテーブルを作成

[参考](https://laravel.com/docs/10.x/migrations#migration-structure)

```php
/**
 * Run the migrations.
 */
public function up(): void
{
    Schema::create('sample_users', function(Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}
```

#### DBへ反映

migrateコマンドでmigrationファイルの変更をDBへ反映する。

[参考](https://laravel.com/docs/10.x/migrations#running-migrations)

```bash
$ php artisan migrate

   INFO  Preparing database.  

  Creating migration table ............................................................................................................... 26ms DONE

   INFO  Running migrations.  

  2014_10_12_000000_create_users_table ................................................................................................... 26ms DONE
  2014_10_12_100000_create_password_reset_tokens_table ................................................................................... 13ms DONE
  2019_08_19_000000_create_failed_jobs_table ............................................................................................. 17ms DONE
  2019_12_14_000001_create_personal_access_tokens_table .................................................................................. 20ms DONE
  2023_02_22_022636_craete_sample_users_table ............................................................................................. 6ms DONE
```

## form画面を表示

骨組みをつくる。

```php
// web.php
Route::get('/signup', [\App\Http\Controllers\SignupController::class, 'index']);
```

```php
// SignupController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function index(): View
    {
        return view('signup.signup');
    }
}
```

```php
// signup.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
</head>
<body>
<form action="#" method="post">
    <input type="text" placeholder="name">
    <input type="submit" value="signup">
</form>
</body>
</html>
```

### POSTされた内容を受け取りたい

#### 名前付きURL

Route->name()でルーティング設定を名前付きURLと対応づけることができる。

[参考](https://laravel.com/docs/10.x/routing#named-routes)

```php
// web.php
Route::get('/signup', [\App\Http\Controllers\SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/post', [\App\Http\Controllers\SignupController::class, 'post'])->name('signup.post');
```

一方、formのactionに設定するときは、route()ヘルパー関数を呼び出す。

```php
<form action="{{route('signup.post')}}" method="post">
```

#### csrf

formからPOSTリクエストを送るときは、例のごとくCSRF対策が必須。
Laravelでは、@csrfディレクティブが担う。

[参考](https://laravel.com/docs/10.x/blade#csrf-field)

#### input

POSTされた内容は`$request->input()`から読み出せる。

[参考](https://laravel.com/docs/10.x/requests#retrieving-input)

以下のように書くと、POSTされたユーザ名が画面に表示される。

```php
public function post(Request $request): string
{
    $message = $request->input('name');
    return $message;
}
```

### バリデーション

入力内容を検証し、問題があれば元の画面へ遷移させてエラーメッセージを表示したい。
[参考](https://laravel.com/docs/10.x/validation)

#### 流れ

* Request->validate()がエントリーポイント
* 各種バリデーションルールが発火
* 失敗した場合、前の画面へのリダイレクトレスポンスが組み立てられる
    * より具体的には、フラッシュの仕組みを利用してformの入力値・エラーメッセージを渡す
* エラーメッセージはビュー変数errorに設定される

#### 実装

Controllerはrequest->validate()を呼び出すだけでよい。

```php
// SignupController.php
public function post(Request $request): string
    $validated = $request->validate([
        'name' => 'required'
    ]);
    
    
    return redirect(route('signup.index'));
}
```

テンプレートへエラーメッセージを表示する領域を追加。

```php
<div>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
</div>
```

### ユーザ情報をDBへ登録したい

ユーザ情報をDBへ登録したい場合、Eloquentの機能を利用。

[参考](https://laravel.com/docs/10.x/eloquent#inserts)

```php
// SignupController.php
public function post(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'name' => 'required'
    ]);

    $model = new SampleUser();
    $model->name = $request->input('name');
    $model->save();

    return redirect(route('signup.index'));
}
```

## 結果画面

### ユーザIDを受け取りたい

1回のリクエストでのみ有効なフラッシュ領域を利用。

[参考](https://laravel.com/docs/10.x/session#flash-data)

### ユーザ情報をDBから取得したい

```php
// SignupController.php
public function result(Request $request): View
{
    // flash領域から識別子を取得
    $userId = $request->session()->get('id');
    // Modelを介してレコードを取得
    $user = SampleUser::find($userId);
    $context = ['user' => $user];

    return view('signup.result', $context);
}
```

```php
// result.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Signup Result</title>
</head>
<body>
<h1>Hello, {{$user->name}}</h1>
</body>
</html>
```

以上をもとにユーザ登録処理を実行すると、結果画面へ登録されたユーザ名が表示されたことを確認。
