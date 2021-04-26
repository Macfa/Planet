<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Comment;

class MainController extends Controller
{
    //
    public function index() {
        $posts = Post::withCount('comments')
            ->with('channel')
            ->where('posts.hide', '=', '0')
            ->get()
            ->toJson();
        $posts = json_decode($posts);

        return view('main.index', compact('posts'));
    }
    
}
