<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request, Status $status){
        $data = $request->validate([
            'body' => 'required',
        ]);
        Auth::user()->comments()->create([
            'status_id' => $status->id,
            'body' => $request->body,
        ]);
        return back();
    }
    public function view(Request $request){
        $status = Status::where('id', $request->status)->first();

        $comments = '';

        foreach ($status->comments as $comment) {
            $comments .= '<div class="d-flex justify-content-between mb-2">
                <div class="col-lg-2 mt-2 text-center">
                    <img class="img-profile-side-down" 
                    src="' . $comment->user->image() . '"
                    alt="Image User">
                </div>
                <div class="col-lg-7">
                    <p class="m-0 pt-2 fw-bolder h6">'. $comment->user->name .'</p>
                    <p class="m-0 mt-2">'. $comment->body .'</p>
                </div>
                <div class="col-lg-3">
                    <p class="m-0 pt-2 text-secondary h6 ms-5">'. $comment->created_at->diffForHumans() .'</p>
                </div>
            </div>';
        }

        $results = '<div class="card-body mt-3">
        <div class="row align-items-center">
            <div class="col-2 text-center">
                <img class="img-profile-side-up"
                    src="' . $status->user->image() . '"
                    alt="Image User">
            </div>
            <div class="col-8 ps-0">
                <p class="m-0 fw-bolder h5">'. $status->user->name .'</p>
                <p class="m-0 pt-1 text-secondary">'.$status->user->created_at->diffForHumans().'</p>
            </div>
            <div class="col-2 text-center">
                <img src="set.png" width="25px" alt="">
            </div>
        </div>
        <hr>
        <div class="mx-2 my-3" style="overflow-y: auto; height: 315px;">
            '.$comments.'
        </div>
        <div class="mx-2">
            <form action="'. route('comment.store', $status->id) .'" method="post">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <div class="d-flex justify-content-between align-items-center">
                    <textarea style="resize: none; height: 40px; width: 90%; border-radius: 20px;"
                        name="body" class="form-control ps-3 pt-2"
                        placeholder="Add a comment..."></textarea>
                    <button class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>';

    return response()->json(['results' => $results]);
    }
}
