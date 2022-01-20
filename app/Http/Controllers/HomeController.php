<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $following = Auth::user()->follows->pluck('id');
        $comments = Comment::get();
        $statuses = Status::whereIn('user_id', $following)
                            ->orWhere('user_id', Auth::user()->id)
                            ->latest()
                            ->get();

        return view('home', compact('statuses', 'comments'));
    }
}
