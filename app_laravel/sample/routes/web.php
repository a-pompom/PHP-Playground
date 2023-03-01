<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', [\App\Http\Controllers\HelloController::class, 'hello']);
Route::get('/fizzBuzz', [\App\Http\Controllers\FizzBuzzController::class, 'view']);

Route::get('/signup', [\App\Http\Controllers\SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/post', [\App\Http\Controllers\SignupController::class, 'post'])->name('signup.post');
Route::get('/signup/result', [\App\Http\Controllers\SignupController::class, 'result'])->name('signup.result');

Route::prefix('crud')->group(function() {

    Route::pattern('tweetId', '[0-9]+');

    Route::get('/', [\App\Http\Controllers\Crud\IndexController::class, 'index'])->name('crud.index');
    Route::get('/create', [\App\Http\Controllers\Crud\CreateController::class, 'index'])->name('crud.create');
    Route::post('/create', [\App\Http\Controllers\Crud\CreateController::class, 'create'])->name('crud.create.create');
    Route::get('/update/{tweetId}', [\App\Http\Controllers\Crud\UpdateController::class, 'index'])->name('crud.update.index');
    Route::post('/update/{tweetId}', [\App\Http\Controllers\Crud\UpdateController::class, 'update'])->name('crud.update.update');

    Route::post('/delete/{tweetId}', [\App\Http\Controllers\Crud\DeleteController::class, 'delete'])->name('crud.delete');
});


