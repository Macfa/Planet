<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Channel;
use App\Models\Comment;

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
}
