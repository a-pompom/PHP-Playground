<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FizzBuzzController extends Controller
{
    /**
     * FizzBuzzメッセージ表示画面
     * @return View
     */
    public function view(): View
    {
        $context = [
            'count' => 15
        ];
        return view('fizzBuzz', $context);
    }
}
