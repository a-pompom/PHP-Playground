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
