<?php

namespace App\Http\Controllers;

use App\Mail\SimpleTest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class registrationController extends Controller
{
    //
    public function Index()
    {
        return view('auth.registration');
    }

    /**
     * Handles user registration by validating input, creating a new user, and logging them in.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Create()
    {
        $check = request()->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['email', 'required', 'max:150'],
            'password' => ['string', 'confirmed', 'min:8'],
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        if (User::where('email', $check['email'])->exists()) {
            # code...
            return back()->withErrors(['error' => 'Email already exists.']);
        }
        $check['password'] = Hash::make($check['password']);
        $check['password_without_hash'] = request('password');
        $check['username']=request('name'); 
        if (request()->hasFile('avatar') ) {
            $file_name = request('name') . request()->file('avatar')->getClientOriginalName();
            $check['avatar'] = request()->file('avatar')->storeAs('public/avatar', $file_name);
        } else {
            $check['avatar'] = 'https://ui-avatars.com/api/?name=' . request('name');
        }
        $user = User::create($check);
        Auth::login($user);
        return redirect()->route('index');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
}
