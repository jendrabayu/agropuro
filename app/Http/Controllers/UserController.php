<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile-setting', ['user' => auth()->user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
            'password' => ['nullable', 'min:5', 'confirmed'],
            'photo' => ['nullable', 'max:1000', 'image']
        ]);

        unset($data['password']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images/user', 'public');
            if (!Arr::hasAny([
                'images/user/avatar-1.png',
                'images/user/avatar-2.png',
                'images/user/avatar-3.png',
                'images/user/avatar-4.png',
                'images/user/avatar-5.png',
            ], $user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
        } else {
            $data['photo'] = $user->photo;
        }

        $user->update($data);

        if ($request->has('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('info', 'Akun Anda Berhasil Diubah');
    }
}
