<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'body' => 'required'
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->body,
            'identifier' => strtolower(Str::random(32)),
        ]);
        return redirect()->back();
    }

    public function delete(Status $status){
        $status->delete();
        $status->comments()->delete();
        $status->saveds()->delete();
        $status->likes()->delete();
        return back();
    }
}
