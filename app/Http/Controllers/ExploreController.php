<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExploreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if($request->search){
            $users = User::where('name', 'LIKE', '%' .$request->search . '%')->paginate(16);
        }else{
            $users = User::paginate(16);
        }
        return view('users.explore', compact('users'));
    }
}
