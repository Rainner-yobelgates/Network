<?php

use App\Models\Like;
use App\Models\Saved;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

function checkBookmark($status_id)
{
    $status = Saved::where('status_id', $status_id)->where('user_id', Auth::user()->id)->first();
    if (!$status) {
        return 'far';
    } else {
        return 'fas';
    }
}
function like($status_id)
{
    $status = Like::where('status_id', $status_id)->where('user_id', Auth::user()->id)->first();
    if (!$status) {
        return 'far';
    } else {
        return 'fas text-danger';
    }
}