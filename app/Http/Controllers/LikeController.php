<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request){
        $status = Status::where('id', $request->status)->first();
        $check = Like::where('status_id', $request->status)->where('user_id', Auth::user()->id)->first();
        if ($check){
            $check->delete();
        }else{
            Auth::user()->likes()->create([
                'status_id' => $request->status
            ]);
        }
        return response()->json([
            'results' => $status->likes->count(),
        ]);
    }
}
