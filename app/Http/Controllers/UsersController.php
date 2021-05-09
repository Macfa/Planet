<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Channel;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function index($el) {
        $posts = Post::with('channel')
        ->with('user')
        ->withCount('comments')
        ->where('memberID', '=', auth()->id())
        ->get()    
        ->toJson();

        $posts = json_decode($posts);
        return view('mypage.index', compact('posts'));
    }

    public function logedIn() {
        if(Auth::check()) {
            return true;
        } else {
            return false;
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with("로그아웃 되었습니다.");
    }
}
