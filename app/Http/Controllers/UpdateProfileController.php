<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UpdateProfileController extends Controller
{
    public function edit(User $user){
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user){
        // $user id pada validasi berfungsi untuk ignore id user yg sedang login
        $data = $request->validate([
            'name' => 'string|min:3|max:191|required',
            'image' => 'image|file|max:2048',
            'email' => 'email|string|min:3|max:191|required|unique:App\Models\User,email,'. $user->id,
            'bio' => 'max:150',
            'username' => 'alpha_num|required|unique:App\Models\User,username,'. $user->id
        ]);
        if($request->file('image')){
            if($user->image){
                Storage::delete($user->image);
            }
            $data['image'] = $request->file('image')->store('profile-image');
        }
        $user->update($data);
        return redirect(route('profile', $user))->with('message', 'Your profile has been updated');
    }

    public function edit_password(User $user){
        return view('password.edit', compact('user'));
    }

    public function update_password(Request $request ,User $user){
        $data = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if(Hash::check($request->current_password, $user->password)){
            $user->update([
                'password' => bcrypt($request->password)
            ]);
            return redirect(route('profile', $user))->with('message', 'Your password has been update');
        };

        throw ValidationException::withMessages([
            'current_password' => 'Your current password does not match with our record'
        ]);
    }
}
