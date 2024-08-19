<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'blog' => blog::paginate(6),
        ]);
    }
    public function CreatePage()
    {
        return view('blog.create');
    }
    public function CreatePost()
    {
        $getData = request()->all();
        $getData['user_id'] = auth()->user()->id;
        unset($getData['_token']);
        $getData['thunmail'] = request()->file('thunmail')->store('public/thunmail');
        blog::create($getData);
        // dd($getData);
        return redirect()->route('blog');
    }

    public function commend($id)
    {
        if (Auth::guest()) {
            return back()->withErrors(['error' => 'You Didnt Have Account To Make Comment']);
        }

        request()->validate([
            'comment' => ['required', 'max:250'],
        ]);
        $data = [
            'user_id' => Auth::user()->id,
            'blog_id' => $id,
            'text' => request('comment'),
        ];
        comments::create($data);
        return back();
    }
    public function page($id)
    {
        $blog = blog::findOrFail($id);
        $commends = Blog::with('comments.user')->find($id)->toArray();
        return view('blog.page', [
            'blog' => $blog,
            'comments' => $commends['comments'],
            'blog_last' => blog::latest()->limit(3)->get(),
        ]);
    }
}
