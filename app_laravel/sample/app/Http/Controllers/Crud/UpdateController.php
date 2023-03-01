<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Crud\UpdateRequest;
use App\Models\Tweet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function index(int $tweetId): View
    {
        $tweet = Tweet::findOrFail($tweetId);
        $context = ['tweet' => $tweet];
        return view('crud.update', $context);
    }

    public function update(UpdateRequest $request, int $tweetId): RedirectResponse
    {
        $tweet = Tweet::find($tweetId);
        $tweet->contents = $request->contents();
        $tweet->save();

        return redirect(route('crud.index'));
    }
}
