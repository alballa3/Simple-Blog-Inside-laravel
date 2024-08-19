<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class profile extends Controller
{
    //
    public function index($id)
    {
        return view('profile.index', [
            'user' => User::findOrFail($id)
        ]);
    }
    public function edit($id){

        return view('profile.file',[
            'user'=>User::findOrFail($id)
        ]);
    }

    public function EditPatch($id){
        $check = request()->validate([
            'name' => ['required', 'string', 'max:50'],
            'username'=>['required', 'string', 'max:50'],
            'description' => ['string', 'max:150'],
            'avatar' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        if(request()->hasFile('avatar')){
            Storage::delete(Auth::user()->avatar);
            $file_name = request('name') . request()->file('avatar')->getClientOriginalName();
            $check['avatar'] = request()->file('avatar')->storeAs('public/avatar', $file_name);
        }
        User::find($id)->update(
            $check
        );
        return redirect()->route('profile',Auth::user()->id);
        // dd(request()->all(),request()->file('avatar'),request());
    }
}
