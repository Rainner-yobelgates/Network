<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{
    public function following(User $user){
        $following = $user->follows;
        return view('users.following', compact('following', 'user'));
    }

    public function follower(User $user){
        $following = $user->followers;
        return view('users.following', compact('following', 'user'));
    }

    public function store(Request $request, User $user){
        $check = Auth::user()->follows()->where('following_user_id', $user->id)->first();
        if ($check) {
            //Unfollow
            Auth::user()->follows()->detach($user);
        } else {
            //Follow
            Auth::user()->follows()->save($user);
        }
        return back()->with('success', 'You are follow the user');
    }
}
