# ゴール

CRUD機能をつくりたい。
今までの復習として、学んだ機能を使いこなせるか試したい。

## 機能イメージ

* つぶやき一覧画面: DBから読み出したつぶやきを一覧で表示
* つぶやき作成画面: DBへ新規登録 FormRequestを使ってみるか
* つぶやき更新画面: DBを主キーをもとに更新
* つぶやき削除画面: DBのレコードを主キーをもとに削除

## DB設定

つぶやき情報を保存するテーブルを作成

### migration

テーブルをDBへつくるためにmigrationファイルを作成・設定。

```bash
# migrationファイルを作成
$ php artisan make:migration

  What should the migration be named?
 create_tweets_table

   INFO  Migration [database/migrations/2023_02_28_031716_create_tweets_table.php] created successfully.  
```

```php
// 2023_02_28_031716_create_tweets_table.php 
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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->string('contents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
```

データベースへテーブルを追加。

```bash
$ php artisan migrate

   INFO  Running migrations.  

  2023_02_28_031716_create_tweets_table .................................................................................................. 19ms DONE
  
```

### Model

テーブルを表現するModelクラスを作成。

```bash
$ php artisan make:model Tweet

   INFO  Model [app/Models/Tweet.php] created successfully. 
```

```bash
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
}
```

## 一覧画面

一覧画面として以下の機能を実装。

* つぶやきを一覧形式で表示
* 登録画面へのリンクを表示

### Controller

Modelを介して取得したつぶやき情報をコンテキストへ設定し、Viewを組み立て。

```php
// Crud/IndexController.php
<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index(): View
    {
        $tweets = Tweet::all();
        $context = [
            'tweets' => $tweets
        ];
        return view('crud.index', $context);
    }

}
```

ルーティングを設定。

```php
Route::prefix('crud')->group(function() {
    Route::get('/', [\App\Http\Controllers\Crud\IndexController::class, 'index'])->name('crud.index');
    Route::get('/create', [\App\Http\Controllers\Crud\CreateController::class, 'index'])->name('crud.create');
});
```

### Template

つぶやき要素を一覧形式で表示。
新規登録画面への参照も持つ。

```php
// crud/index.blade.php
{{--一覧--}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tweet List</title>
</head>
<body>
<a href="{{route('crud.create')}}"><button type="button">Add</button></a>
<ul>
    @foreach($tweets as $tweet)
        <li>{{$tweet->contents}}</li>
    @endforeach
</ul>
</body>
</html>
```

## 登録

* 画面の入力値を検証
* 検証して問題なければDBへつぶやき情報を登録
* 登録後は一覧へリダイレクト

### 画面表示

#### Controller

```php
// Crud/CreateController.php
<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * つぶやき作成画面のリクエスト制御を責務に持つ
 */
class CreateController extends Controller
{
    /**
     * 作成画面表示
     * @return View
     */
    public function index(): View
    {
        return view('crud.create');
    }
}
```

#### Template

ここでは単に画面を表示するのみ。

```php
// crud/create.blade.php
{{--作成--}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tweet Create</title>
</head>
<body>
<a href="{{route('crud.index')}}"><button type="button">Index</button></a>
</body>
</html>
```

#### Routing

```php
// web.php
Route::prefix('crud')->group(function() {
    Route::get('/', [\App\Http\Controllers\Crud\IndexController::class, 'index'])->name('crud.index');
    Route::get('/create', [\App\Http\Controllers\Crud\CreateController::class, 'index'])->name('crud.create');
});
```

### 登録機能

#### Request

Validation RuleをまとめたFormRequestオブジェクトを作成。

```php
$ php artisan make:request Crud/CreateRequest

   INFO  Request [app/Http/Requests/Crud/CreateRequest.php] created successfully.  
```

```php
// Requests/Crud/CreateRequest.php
<?php

namespace App\Http\Requests\Crud;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function contents(): string
    {
        return $this->input('contents');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'contents' => 'required',
        ];
    }
}
```

#### View

登録formをもつ画面を作成。

```php
{{--作成--}}
    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Tweet Create</title>
</head>
<body>
<a href="{{route('crud.index')}}">
    <button type="button">Index</button>
</a>

<div>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
</div>

<form method="post" action="{{route('crud.create.create')}}">
    @csrf
    <label for="contents">Contents</label>
    <input
        id="contents"
        type="text"
        name="contents"
    >

    <input type="submit" value="Create">
</form>
</body>
</html>
```

#### Controller

ValidationはFormRequestオブジェクトが担うので、Controllerは単に登録処理を実装するだけでよい。
また、FormRequestはServiceContainerによりインスタンスが注入される。

```php
// CreateController.php
    /**
     * 登録処理
     * @param CreateRequest $request
     * @return RedirectResponse 一覧画面へのリダイレクト
     */
    public function create(CreateRequest $request): RedirectResponse
    {
        $tweet = new Tweet();
        $tweet->contents = $request->contents();
        $tweet->save();

        return redirect(route('crud.index'));
    }
```

## 更新

* 主キーをもとに更新画面へ遷移
* 主キーを指定してつぶやき情報を更新

以上の処理を作成。

### 更新画面

#### Index View

```php
// create.blade.php
    <li>
        {{$tweet->contents}}
        <a href="{{route('crud.update.index', ['tweetId' => $tweet->id])}}">
            <button type="button">Update</button>
        </a>
    </li>
```

#### Controller

パスパラメータの主キーをもとにDBからレコードを取得。
レコードを画面を描画するときのコンテキストへ設定。

```php
// UpdateController.php
    public function index(int $tweetId): View
    {
        $tweet = Tweet::findOrFail($tweetId);
        $context = ['tweet' => $tweet];
        return view('crud.update', $context);
    }
```

#### View

```php
{{--更新--}}
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tweet Update</title>
</head>
<body>
<a href="{{route('crud.index')}}">
    <button type="button">Index</button>
</a>
<div>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    @endif
</div>
<form method="post" action="{{route('crud.update.update', ['tweetId' => $tweet->id])}}">
    @csrf
    <label for="contents">Contents</label>
    <input
        id="contents"
        type="text"
        name="contents"
        value="{{$tweet->contents}}"
    >

    <input type="submit" value="Update">
</form>
</body>
</html>
```

### 更新機能

#### FormRequest

```php
// UpdateRequest.php
<?php

namespace App\Http\Requests\Crud;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function contents(): string
    {
        return $this->input('contents');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'contents' => 'required',
        ];
    }
}
```

#### Controller

```php
// UpdateController.php
    public function update(UpdateRequest $request, int $tweetId): RedirectResponse
    {
        $tweet = Tweet::find($tweetId);
        $tweet->contents = $request->contents();
        $tweet->save();

        return redirect(route('crud.index'));
    }
```

## 削除

* 主キーをもとにレコードを削除

以上の機能を作成。

### View

```php
<ul>
    @foreach($tweets as $tweet)
        <li>
            {{$tweet->contents}}
            <a href="{{route('crud.update.index', ['tweetId' => $tweet->id])}}">
                <button type="button">Update</button>
            </a>
            <form method="post" action="{{route('crud.delete', ['tweetId' => $tweet->id])}}">
                @csrf
                <input type="submit" value="Delete">
            </form>
        </li>
    @endforeach
</ul>
```

### Controller

```php
// DeleteController.php
<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    //
    public function delete(int $tweetId): RedirectResponse
    {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->delete();

        return redirect(route('crud.index'));
    }
}
```