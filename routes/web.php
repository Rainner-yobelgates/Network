<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SavedController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\UpdateProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function(){
    Route::get('/home', HomeController::class)->name('home');
    Route::get('/home/comments/view', [CommentController::class, 'view'])->name('comment.view');
    Route::get('/home/bookmark/store', [SavedController::class, 'store'])->name('bookmark.store');
    Route::get('/home/heart/store', [LikeController::class, 'store'])->name('heart.store');
    Route::post('/home/comment/{status}/store', [CommentController::class, 'store'])->name('comment.store');

    Route::post('/status/store', [StatusController::class, 'store'])->name('status.store');
    Route::delete('/status/delete/{status:identifier}', [StatusController::class, 'delete'])->name('status.delete');

    Route::get('/explore', ExploreController::class)->name('explore');

    Route::get('/profile/{user:username}', ProfileController::class)->name('profile')->withoutMiddleware('auth');
    Route::get('/profile/{user:username}/following', [FollowingController::class, 'following'])->name('profile.following');
    
    Route::get('/profile/{user:username}/edit', [UpdateProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user:username}/update', [UpdateProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/profile/{user:username}/password/edit', [UpdateProfileController::class, 'edit_password'])->name('pass.edit');
    Route::put('/profile/{user:username}/password/update', [UpdateProfileController::class, 'update_password'])->name('pass.update');
    
    Route::get('/profile/{user:username}/follower', [FollowingController::class, 'follower'])->name('profile.follower');
    Route::post('/profile/{user:username}', [FollowingController::class, 'store'])->name('following.store');
});


require __DIR__.'/auth.php';
