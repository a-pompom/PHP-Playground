<?php

namespace App\Http\Controllers;

use App\Models\SampleUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * ユーザ登録処理の制御を責務に持つ
 */
class SignupController extends Controller
{
    /**
     * ユーザ登録画面
     * @return View
     */
    public function index(): View
    {
        return view('signup.signup');
    }

    /**
     * ユーザ登録処理
     * @param Request $request
     * @return RedirectResponse ユーザ登録結果画面へのリダイレクトレスポンス
     */
    public function post(Request $request): RedirectResponse
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $model = new SampleUser();
        $model->name = $request->input('name');
        $model->save();

        // 結果画面で読み出せるようIDを受け渡し
        $request->session()->flash('id', $model->id);

        // PRGパターンに則り、リダイレクトで遷移
        return redirect(route('signup.result'));
    }

    /**
     * ユーザ登録結果画面
     * @param Request $request
     * @return View
     */
    public function result(Request $request): View
    {
        $userId = $request->session()->get('id');
        $user = SampleUser::find($userId);
        $context = ['user' => $user];

        return view('signup.result', $context);
    }
}
