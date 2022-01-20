<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Saved;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user)
    {
        $statuses = $user->statuses()->latest()->get();
        $saveds = Saved::where('user_id', $user->id)->latest()->get();
        $following = $user->follows;
        $followers = $user->followers;

        return view('users.profile', compact('user', 'statuses', 'following', 'followers', 'saveds'));
    }
}
