<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Saved;
use Illuminate\Support\Facades\Auth;

class SavedController extends Controller
{
    public function store(Request $request){
        $check = Saved::where('status_id', $request->status)->where('user_id', Auth::user()->id)->first();
        if ($check){
            $check->delete();
        }else{
            Auth::user()->saveds()->create([
                'status_id' => $request->status
            ]);
        }
        return response()->json([
            'results' => 'Success'
        ]);
    }
}
