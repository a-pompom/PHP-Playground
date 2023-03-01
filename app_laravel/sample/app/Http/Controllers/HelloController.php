<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
