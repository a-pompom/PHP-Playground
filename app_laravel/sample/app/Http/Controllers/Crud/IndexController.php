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
