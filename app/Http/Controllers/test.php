<?php

namespace App\Http\Controllers;

use App\Models\User as ModelUser;
use Illuminate\Http\Request;

class test extends Controller
{
    //
    public function test(){
        $user=ModelUser::find(1);
        dd($user->blog()->count(),$user->comments()->count());
    // dd();
    }
    
}
