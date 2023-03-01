<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\CreateRequest;
use App\Models\Tweet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
}

